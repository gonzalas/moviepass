<?php
    namespace Helpers;

    class Carousel {

        public static function generateCarouselMovies($movies, $moviesOnCarousel){
            $carouselListing = array();
            if(count($movies) >= $moviesOnCarousel){

                for($i = 0; $i < $moviesOnCarousel; $i++){  
                    array_push($carouselListing, $movies[$i]);
                }
            } else {
                $carouselListing = [];
            }                        
            return $carouselListing;
        }   

        private function getArrayRandom($movies, $number){
            $i = 0;
            $random = array();
            while($i < $number){
                $random[$i] = rand(0, count($movies) - 1);
                while(in_array($random[$i], $random)){
                    $random[$i] = rand(0, count($movies) - 1);
                }
                var_dump($random[$i]);
                array_push($random, $random[$i]);
                $i++;
            }
            array_pop($random);
            var_dump($random);
            return $random;
        }
    }

?>