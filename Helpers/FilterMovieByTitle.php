<?php
    namespace Helpers;

    class FilterMovieByTitle {

        public static function ApplyFilter($moviesAll, $movieTitle){
            return array_filter($moviesAll, function($m) use ($movieTitle){
                return (stripos($m->getTitle(), $movieTitle) !== false);
            });
        }
    }

?>