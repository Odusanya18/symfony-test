<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Accounts;
use AppBundle\Entity\Country;
use AppBundle\Entity\Genre;
use AppBundle\Entity\Films;
use AppBundle\Entity\Comments;

class LoadAllData implements FixtureInterface
{

	/**
	 * @param ObjectManager $manager
	 */
    public function load(ObjectManager $manager)
    {
    	/**
    	 * @var Accounts $accounts[]
    	 * @var Country $country[]
    	 * @var Genre $genre[]
    	 * @var Films $film[]
         * @var Comments $comment[]
    	 */
    	for ($i=0; $i < 10 ; $i++) {
    		$account[$i] = new Accounts();
    		$account[$i]->setFirstname('Movie')
    			->setLastname('Editor '.($i+1))
    			->setEmail('editor-'.($i+1).'@movies.com')
    			->setPlainPassword('carter');
    		$manager->persist($account[$i]);
    	}
    	for ($i=0; $i < 5 ; $i++) { 
    		$country[$i] = new Country();
    		$country[$i]->setName('country '.($i+1));
    		$manager->persist($country[$i]);
    	}
    	for ($i=0; $i < 5 ; $i++) { 
    		$genre[$i] = new Genre();
    		$genre[$i]->setName('genre '.($i+1));
    		$manager->persist($genre[$i]);
    	}
    	for ($i=0; $i < 200 ; $i++) { 
    		$film[$i] = new Films();
    		$film[$i]->setImage('film-'.rand(1,5).'.jpg')
    			->setName('Moana '.($i+1))
    			->setDescription('This is a very interesting movie, just as
    				interesting as an animation can be.')
    			->setReleaseDate(new \DateTime())
    			->setRating(rand(0,5))
    			->setTicketPrice(rand(55, 855))
    			->setCountry($country[rand(0,4)])
    			->setGenre($genre[rand(0,4)]);
    		$manager->persist($film[$i]);

            //Set 3 comments per movie

            for ($j=0; $j < 3 ; $j++) { 
                $user = $account[rand(0,9)]; 
                $comment[$i][$j] = new Comments();
                $comment[$i][$j]->setName($user->getFirstName().' '.$user->getLastName())
                    ->setFilmId($film[$i])
                    ->setComment('Interesing would love 
                    to watch again');
                $manager->persist($comment[$i][$j]);
            }
    	}
    	$manager->flush();
    }
}
