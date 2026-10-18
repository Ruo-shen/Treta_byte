<?php

/*
 * FAQ content, one list per place: 'home' and 'services.<slug>'.
 * Each entry is ['q' => question, 'a' => answer] (answers reuse approved site copy only) or
 * ['placeholder' => 'what is missing'] (renders only when APP_ENV=local, via x-inner.placeholder).
 * Replace placeholders with real, approved entries to publish them. Never invent policies, prices, timelines or guarantees.
 */
return [
    'home' => [
        ['q' => 'What if I don’t know what’s wrong?', 'a' => 'An error message helps. So does “the form stopped sending on Tuesday.” You don’t need to diagnose it first.'],
        ['q' => 'Who will I be talking to?', 'a' => 'You talk directly to the people doing the work — a small team taking responsibility from the first conversation onward.'],
        ['q' => 'How does it start?', 'a' => 'We start with a conversation about what is working, what is not, and what success should look like.'],
        ['q' => 'What happens after launch?', 'a' => 'After launch we stay close: monitoring, improving and fixing before small issues become big ones.'],
        ['q' => 'What if my problem isn’t on your list?', 'a' => 'Tell us what\'s going on. We\'ll reply with honest next steps — even if that means pointing you elsewhere.'],
        ['placeholder' => 'FAQ: how pricing works (owner to supply approved answer)'],
        ['placeholder' => 'FAQ: typical timelines and reply times (owner to supply approved answer)'],
    ],
    'services' => [
        'website-repair' => [
            ['q' => 'Is a symptom enough to start with?', 'a' => 'An error message helps. So does “the form stopped sending on Tuesday.” You don’t need to diagnose it first.'],
            ['q' => 'What happens before a live system is changed?', 'a' => 'We review the setup and discuss access, backups and a safe place to test before changing a live system.'],
            ['q' => 'What if a rebuild makes more sense?', 'a' => 'If a rebuild is more sensible than another repair, we’ll explain that tradeoff.'],
            ['placeholder' => 'FAQ: repair pricing and typical turnaround (owner to supply approved answer)'],
        ],
        'web-development' => [
            ['q' => 'What should a website do for visitors?', 'a' => 'Structure and language that make the business understandable, without making visitors work for it.'],
            ['q' => 'What do we get at hand over?', 'a' => 'A clear launch plan, access and documentation for the people maintaining it.'],
            ['q' => 'Who decides what is included?', 'a' => 'The right scope depends on your setup. We agree what’s included before we start.'],
            ['placeholder' => 'FAQ: website pricing and typical timeline (owner to supply approved answer)'],
        ],
        'web-applications' => [
            ['q' => 'How does an application project start?', 'a' => 'We start with how your team works today: what comes in, where information moves, who needs to act, and where things get stuck.'],
            ['q' => 'Do we need a custom application?', 'a' => 'Sometimes the answer is connecting existing tools. Sometimes it’s a small internal application. We agree a focused scope, test it against real tasks, and leave room to learn.'],
            ['q' => 'What about access and security?', 'a' => 'Access controls, validation, error states and handover are part of the conversation — not details to discover at the end.'],
            ['placeholder' => 'FAQ: application pricing and typical timeline (owner to supply approved answer)'],
        ],
        'website-maintenance' => [
            ['q' => 'What does a maintenance arrangement start with?', 'a' => 'A maintenance arrangement starts with understanding the system you have. We agree responsibilities, communication, access and what to do when something needs attention.'],
            ['q' => 'Is the scope fixed?', 'a' => 'The right scope depends on your setup. Actual scope and timing are agreed together.'],
            ['q' => 'How are larger changes handled?', 'a' => 'Additional work: how larger changes are scoped, reviewed and approved.'],
            ['placeholder' => 'FAQ: care plan pricing and response times (owner to supply approved answer)'],
        ],
    ],
];
