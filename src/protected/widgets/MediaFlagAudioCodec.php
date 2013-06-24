<?php

/**
 * Audio codec flag
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 */
class MediaFlagAudioCodec extends MediaFlag
{

	protected function getIcon()
	{
		$codec = $this->audio->codec;

		$icons = array(
			'aac'=>'80px-Aac',
			'ac3'=>'80px-Ac3',
			'aac'=>'80px-Aac',
			'dts'=>'80px-Dts',
			'dtshd_ma'=>'80px-Dtshd_ma',
			'flac'=>'80px-Flac',
			'mp3'=>'80px-Mp3',
			'aac'=>'80px-Aac',
			'pcm'=>'80px-Pcm_bluray',
			'truehd'=>'80px-Truehd',
		);

		if (array_key_exists($codec, $icons))
			return $icons[$codec];
		elseif (stripos($codec, 'pcm'))
			return $icons['pcm'];
	}

}