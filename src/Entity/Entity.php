<?php

namespace App\Entity;

use App\App;

abstract class Entity
{
    /**
     * Méthode magique // Magic method
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    /**
     * Gestion des dates // Date management
     * @param string $format
     * @param string $type
     * @return array|string
     */
    public function date_fr(string $format, string $type)
    {
        setlocale(LC_TIME, "fr_FR", "French");
        if ($type == 'created_at') {
            $date = $this->created_at;
            $date = strtotime("$date");
            if ($format == 'long') {
                $date = strftime('%A %d %B %Y', $date);

                return $date;

            } elseif ($format == 'short') {
                $day = strftime('%e', $date);
                $date = strftime('%m/%Y', $date);

                return [$day, $date];

            } elseif ($format == 'exact') {
                $date = strftime('%e/%m/%Y à %T', $date);

                return $date;
            }
        } elseif ($type == 'modify_at') {
            $date = $this->modify_at;
            $date = strtotime("$date");
            if ($format == 'long') {
                $date = strftime('%A %d %B %Y', $date);

                return $date;

            } elseif ($format == 'short') {
                $day = strftime('%e', $date);
                $date = strftime('%m/%Y', $date);

                return [$day, $date];

            } elseif ($format == 'exact') {
                $date = strftime('%e/%m/%Y à %T', $date);

                return $date;
            }
        }
    }
}