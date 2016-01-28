<?php

/**
 * @file
 * Default theme implementation to moderate one piece of content.
 *
 *  * Available variables:
 * - $object: The content that requires moderation
 * - $offences: Total offences by account
 * - $warnings: Total email warnings sent to account
 * - $moderate: Moderation form
 *
 * @see template_preprocess()
 * @see template_preprocess_abuse_report()
 */
?>

<fieldset class="abuse-report corners fieldset form-wrapper">
  <div class="summary fieldset-wrapper">
    <h2><?php print l($object->title, $object->path['URL'], array('query' => $object->path['QUERY'], 'fragment' => $object->path['BREADCRUMB'])); ?></h2>
    <fieldset class="abuse-report corners fieldset collapsible form-wrapper">
      <legend><span class="fieldset-legend"><a class="fieldset-title" href="#"><span class="fieldset-legend-prefix element-invisible">Show</span><?php print t('User'); ?></a><span class="summary"></span></span></legend>
      <div class="summary fieldset-wrapper">
        <label><?php print t('Type:'); ?></label>
        <div class="description"><?php print drupal_ucfirst($object->content_type); ?></div>
        <label><?php print t('Status:'); ?></label>
        <div class="description"><?php print $object->abuse_status_string; ?></div>
        <?php if (variable_get('abuse_assigned_moderators', FALSE)): ?>
          <label><?php print t('Assigned To:'); ?></label>
          <div class="description"><?php print $object->abuse_assigned_to_name; ?></div>
        <?php endif; ?>
        <?php if (!empty($object->description)): ?>
          <p><?php print $object->description['safe_value']; ?></p>
        <?php endif; ?>
        <label><?php print t('By:'); ?></label>
        <div class="description"><?php print t('!username', array('!username' => theme('username', array('account' => $object->account)))); ?></div>
        <label><?php print t('Email'); ?>:</label>
        <div class="description"><?php print $object->account->mail; ?></div>
        <label><?php print t('Age'); ?>:</label>
        <div class="description"><?php print theme('age', $object->account->uid); ?></div>
        <label><?php print t('Offences'); ?>:</label>
        <div class="description"><?php print $offences; ?></div>
        <label><?php print t('Warnings'); ?>:</label>
        <div class="description"><?php print $warnings; ?></div>
        <label><?php print t('User links'); ?>:</label>
        <ul class="links">
          <li><?php print l(t('Edit Account'), 'user/'. $object->account->uid .'/edit'); ?></li>
          <li><?php print l(t('View Account History'), 'admin/abuse/status/user/'. $object->account->uid); ?></li>
        </ul>
      </div>
    </fieldset>
    <div class="details clear-block">
      <div class="column column-first">
        <?php print render($object->content); ?>
      </div>
      <div class="column column-last">
        <fieldset class="abuse-report-allow collapsible form-wrapper">
          <legend><span class="fieldset-legend"><a class="fieldset-title" href="#"><span class="fieldset-legend-prefix element-invisible">Show</span><?php print t('History'); ?></a><span class="summary"></span></span></legend>
          <div class="fieldset-wrapper">
            <div class="history">
              <label><?php print t('History'); ?></label>
              <?php if (count($object->history)): ?>
                <?php foreach ($object->history as $log): ?>
                <div>
                  <strong><?php print $log->flagger; ?>:</strong>
                  <?php print t('Changed status to %status', array('%status' => $log->readable_status)); ?>
                </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div><?php print t('None');?></div>
              <?php endif; ?>
            </div>
            <div class="warnings">
              <label><?php print t('Warnings'); ?></label>
              <?php if (count($object->warnings)): ?>
                <?php foreach ($object->warnings as $warning): ?>
                <div>
                  <strong><?php print $warning->name; ?>:</strong>
                  <?php print t('sent warning on %date', array('%date' => $warning->date)); ?>
                </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div><?php print t('None');?></div>
              <?php endif; ?>
            </div>
            <div class="flags">
              <label><?php print t('Flags'); ?></label>
              <?php if (count($object->reports)): ?>
                <?php foreach ($object->reports as $report): ?>
                  <div>
                    <strong><?php print strcasecmp($report->name, t('Watchlist')) == 0 ? t('Watchlist') : theme('username', array('account' => $object->account)); ?></strong>
                    <?php print format_date($report->created); ?>:<br />
                    <?php print check_plain(urldecode($report->body)); ?>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div><?php print t('None');?></div>
              <?php endif; ?>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <div class="actions">
      <h3><?php print t('Actions'); ?></h3>
      <?php print render($moderate); ?>
    </div>
  </div>
</fieldset>