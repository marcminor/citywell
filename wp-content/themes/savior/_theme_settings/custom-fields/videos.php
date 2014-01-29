<?php

// Panel for Videos
$video_link = ECF_Field::factory('text', 'video_link', 'Link to Video');
$video_link->help_text(__('Paste the link here to a <strong>Vimeo</strong> or <strong>Youtube</strong> video page.<br /><br /><strong>Youtube Example:</strong> http://www.youtube.com/watch?v=UF8uR6Z6KLc<br /><strong>Vimeo Example:</strong> http://vimeo.com/30195371','savior'));
$video_link_panel = new ECF_Panel('video_link_panel', __('Video Link','savior'), 'video-items', 'normal', 'high');
$video_link_panel->add_fields(array( $video_link ));

?>