<?php

/**
 * Video codec flag
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 */
class MediaFlagVideoCodec extends MediaFlag
{

	protected function getIcon()
	{
		$codec = $this->video->codec;

		$icons = array(
			'h264'=>'80px-H264',
			'xvid'=>'80px-Xvid',
			'dx50'=>'80px-Divx',
			'avc1'=>'80px-Avc1');

		return array_key_exists($codec, $icons) ? $icons[$codec] : false;
	}

}