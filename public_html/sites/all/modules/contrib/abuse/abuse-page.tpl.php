<?php

/**
 * @file
 * Default theme implementation to show content that requires moderation
 *
 *  * Available variables:
 * - $reports: An array of reports
 *
 * @see template_preprocess()
 * @see template_preprocess_abuse_page()
 */
?>
<div id="message-wrapper" class="message status"></div>
<ul class="abuse-report-list">
  <?php foreach ($reports as $report): ?>
    <?php print theme('abuse_report', array('object' => $report)); ?>
  <?php endforeach; ?>
</ul>

<?php // hide the controls for the main abuse page on the individual ticket page ?>
<?php if (!preg_match('/^admin\/abuse\/status/i', request_path())): ?>
  <div id="abuse-report-list-controls">
    <?php print l(t('Get More Tickets'), request_path()); ?>
  </div>
<?php endif; ?>

<!--
<?php print theme('pager', array(), 10, 0); ?>
<?php $total = count($reports); ?>
<?php pager_default_initialize($total, 1, $element = 0); ?>
<?php print theme('pager', array('quantity' => $total)); ?>
-->
