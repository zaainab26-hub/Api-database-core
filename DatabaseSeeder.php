<?php

declare(strict_types=1);

return function (PDO $pdo): void {
    // Clear in dependency order so the seeder can be safely rerun in development.
    $pdo->exec('DELETE FROM activity_logs');
    $pdo->exec('DELETE FROM leads');
    $pdo->exec('DELETE FROM pipelines');
    $pdo->exec('DELETE FROM contacts');

    $contactStatement = $pdo->prepare(
        'INSERT INTO contacts (name, email, phone, company, job_title, notes)
         VALUES (?, ?, ?, ?, ?, ?)'
    );

    $contacts = [
        ['Ali Raza', 'ali.raza@example.com', '+92 300 1111111', 'TechNova Solutions', 'Founder', 'Interested in a CRM implementation.'],
        ['Sara Ahmed', 'sara.ahmed@example.com', '+92 301 2222222', 'Bright Retail', 'Operations Manager', 'Requested a product demonstration.'],
        ['Hamza Malik', 'hamza.malik@example.com', '+92 302 3333333', 'BluePeak Media', 'Marketing Lead', 'Referral from an existing customer.'],
        ['Ayesha Khan', 'ayesha.khan@example.com', '+92 303 4444444', 'GreenField Traders', 'Director', 'Needs sales pipeline automation.'],
        ['Usman Tariq', 'usman.tariq@example.com', '+92 304 5555555', 'NextGen Systems', 'CTO', 'Technical discussion completed.'],
    ];

    foreach ($contacts as $contact) {
        $contactStatement->execute($contact);
    }

    $pipelineStatement = $pdo->prepare(
        'INSERT INTO pipelines (name, description, stages, is_active)
         VALUES (?, ?, ?, ?)'
    );

    $pipelineStatement->execute([
        'Sales Pipeline',
        'Main pipeline for sales opportunities.',
        json_encode(['New', 'Qualified', 'Proposal', 'Won', 'Lost'], JSON_THROW_ON_ERROR),
        1,
    ]);

    $pipelineStatement->execute([
        'Partnership Pipeline',
        'Pipeline for strategic partnership opportunities.',
        json_encode(['New', 'Discovery', 'Negotiation', 'Won', 'Lost'], JSON_THROW_ON_ERROR),
        1,
    ]);

    $leadStatement = $pdo->prepare(
        'INSERT INTO leads
        (contact_id, pipeline_id, title, status, stage, source, estimated_value, expected_close_date, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $leads = [
        [1, 1, 'CRM Implementation', 'qualified', 'Qualified', 'Website', 150000.00, '2026-09-15', 'Full CRM setup and onboarding.'],
        [2, 1, 'Retail Sales Automation', 'proposal', 'Proposal', 'Referral', 95000.00, '2026-09-25', 'Proposal sent for review.'],
        [3, 1, 'Marketing Dashboard', 'new', 'New', 'Social Media', 60000.00, '2026-10-05', 'Initial requirements received.'],
        [4, 2, 'Strategic Technology Partnership', 'qualified', 'Discovery', 'Referral', 220000.00, '2026-10-20', 'Discovery call completed.'],
        [5, 1, 'Enterprise API Integration', 'won', 'Won', 'Direct', 300000.00, '2026-08-30', 'Contract approved.'],
    ];

    foreach ($leads as $lead) {
        $leadStatement->execute($lead);
    }

    $activityStatement = $pdo->prepare(
        'INSERT INTO activity_logs (lead_id, activity_type, description, activity_at)
         VALUES (?, ?, ?, ?)'
    );

    $activities = [
        [1, 'call', 'Initial discovery call completed.', '2026-08-17 10:00:00'],
        [1, 'email', 'Sent CRM requirements summary.', '2026-08-17 15:30:00'],
        [2, 'meeting', 'Proposal review meeting completed.', '2026-08-18 11:00:00'],
        [2, 'status_change', 'Lead moved from Qualified to Proposal.', '2026-08-18 13:00:00'],
        [3, 'note', 'Customer requested dashboard examples.', '2026-08-18 14:15:00'],
        [4, 'meeting', 'Partnership discovery meeting completed.', '2026-08-18 16:00:00'],
        [5, 'status_change', 'Lead marked as Won after contract approval.', '2026-08-18 17:00:00'],
        [5, 'task', 'Schedule implementation kickoff.', '2026-08-19 09:00:00'],
    ];

    foreach ($activities as $activity) {
        $activityStatement->execute($activity);
    }
};
