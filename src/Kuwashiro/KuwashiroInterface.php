<?php

namespace KuwashiroBuster\Kuwashiro;

interface KuwashiroInterface
{
    public function getGeneration();

    public function isHatch();

    public function getYukoSekisanOndo();

    public function getHatsuikuZeroTen();

    public function getHatsuikuTeishiOndo();

    public function isSekisanEnabled();

    public function grow($temperature);

    public function getCurrentYukioSekisanOndo();

    public function getCoverType();

    public function enableSekisan($enabled);
}