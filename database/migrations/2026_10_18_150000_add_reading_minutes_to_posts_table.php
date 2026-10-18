<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedSmallInteger('reading_minutes')->nullable()->after('content');
        });

        // Backfill existing posts with the same calculation the saving hook uses.
        Post::query()->each(fn (Post $post) => DB::table('posts')
            ->where('id', $post->id)
            ->update(['reading_minutes' => $post->calculateReadingMinutes()]));
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('reading_minutes');
        });
    }
};
