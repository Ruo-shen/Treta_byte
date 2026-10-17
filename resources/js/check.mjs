import assert from "node:assert/strict"
import { readFileSync, readdirSync } from "node:fs"
import { join } from "node:path"

// Run after `npm run build`; catches broken asset contracts and accidental unapproved content.
const walk = (dir) =>
  readdirSync(dir, { withFileTypes: true }).flatMap((entry) =>
    entry.isDirectory() ? walk(join(dir, entry.name)) : [join(dir, entry.name)],
  )
const views = walk("resources/views")
for (const file of views) {
  const source = readFileSync(file, "utf8")
  assert.doesNotMatch(
    source,
    /treta\.studio|Trusted by teams|Client name to be added|Outcome to be added|images\.unsplash\.com/,
    file,
  )
  const ids = [...source.matchAll(/\bid="([^"]+)"/g)].map((match) => match[1])
  assert.equal(
    ids.length,
    new Set(ids).size,
    `Duplicate HTML/SVG id in ${file}`,
  )
}
const manifest = JSON.parse(readFileSync("public/build/manifest.json", "utf8"))
for (const entry of ["resources/css/app.css", "resources/js/app.ts"]) {
  assert.ok(manifest[entry]?.isEntry, `Missing Vite entry: ${entry}`)
  assert.ok(readFileSync(`public/build/${manifest[entry].file}`).length)
}
const layout = readFileSync("resources/views/layouts/app.blade.php", "utf8")
assert.match(layout, /<main id="main-content"/)
assert.match(layout, /JSON_HEX_TAG/)
assert.match(layout, /name="description"/)
assert.match(layout, /rel="canonical"/)
console.log(
  `Checked ${views.length} Blade templates and both production asset entries.`,
)
