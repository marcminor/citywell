<?php

// Panel for Audio Items
$audiofile_mp3 = ECF_Field::factory('file', 'file_mp3', 'MP3 File');
$audiofile_mp3->help_text(__('Upload the MP3 version of your audio file.','savior'));
$audiofile_external_mp3 = ECF_Field::factory('text', '_file_external_mp3', 'External MP3 File');
$audiofile_external_mp3->help_text(__('Alternatively, link to an external MP3 file. This will override any uploaded ones.','savior'));

$audio_files_panel = new ECF_Panel('audio_files_panel', __('Upload Audio Files','savior'), 'audio-items', 'normal', 'high');
$audio_files_panel->add_fields(array( $audiofile_mp3, $audiofile_external_mp3));

?>