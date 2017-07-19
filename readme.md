<b>Test Project 2:</b><br><br>
	<p><i>The test project is aimed at testing knowledge of best practices, anti-patterns and basic understanding
	of symfony and the likes... It strongly embraces concepts such as modularity, service registration, abstraction,
	dependency injection and many other practices associated with OOP and other professional design practices.
	In-code documentation is provided with phpDocs.
	The project is a simple film inventory system.</i></p>

<b>Getting Started:</b><br><br>
	</p>Clone the repository and delete the files under @app/DoctrineMigrations, it is absolutely not needed but only provides
	the equivalent of a MySQL git. Open a terminal in the home directory.</p>

<b>Prerequisites:</b><br><br>
	<p>1. Php version >= 5.5.9 <br>
	2. Composer <br>
	3. MySQL server or MariaDB <br>
	4. Attention <br></p>



<b>About:</b><br><br>
	<p>The test project was setup using the latest symfony version 3.3.5 .
	The default ORM is doctrine(laravel's eloquent equivalent), and uses doctrine's
	migrations equivalent for migrations and doctrine's fixtures for fixtures('laravel seeder equivalent')</p>

<b>Installing:</b>

	1.Install composer globally, instructions can be found at getcomposer.org

	2.Setup a MySQL database with parameters of your choice, an example template can be found @app/config/parameters.yml.dist

	3.Update the parameters.yml file under @app/config/

	4.Open a terminal in the project's home directory

	5.Run commands

		./bin/console doctrine:migrations:generate
			AND
		./bin/console doctrine:migrations:migrate
			AND
		./bin/console doctrine:fixtures:load

	 to load the database fixtures(seeders)

	6.Install the project assets with

		./bin/console assets:install

	6.Run the Symfony web server by command

		./bin/console server:run
		 	OR
		./bin/console server:start

	 -interchangable on unix systems)

	7.Browse the project @localhost:8000


<b>Notes:</b>
	
	1.Symfony 3.3.5 is not yet stable, even though it's marked stable, I personally encountered issues when integrating
	bundles not yet adapted for version 3.3.5.
	
	2.Console command

		./bin/console server:start

	is non-blocking and doesn't work on Mac systems where such isn't supported, so use:

		php bin/console server:run

	3.Console commands as described above prefixed with:

		./ as in ./bin/console ....

	  only works on linux, prefix with

	  	php  instead, as in php bin/console ....

	  on Mac and Windows Systems.

	4.For more administrational activities, the admin panel is located @localhost:8000/admin.

<b>Coding standard:</b><br><br>
	<p>The project adheres to the following coding standards:<br>
		PSR-1<br>
		PSR-2<br>
		PSR-4<br>
		PSR-5<br>
		PSR-12.<br></p>

<b>Built With:</b><br><br>
	<p>1.Php<br>
	2.Symfony<br>
	3.Composer<br></p>

<b>Authors:</b><br><br>
	<p>-Odusanya Victor -	<i>Initial work</i></p>
