<?php

namespace Votolab\VotolabBundle\Twig;

class VotolabExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('embed', array($this, 'getEmbedCode')),
        );
    }

    public function getEmbedCode($videoUrl, $width = null, $height = null)
    {
        $options = array(
            'params' => array('width' => $width, 'height' => $height)
        );
        $embera = new \Embera\Embera($options);
        $embedCode = $embera->autoEmbed($videoUrl);

        return $embedCode;
    }

    public function getName()
    {
        return 'votolab_extension';
    }
}

