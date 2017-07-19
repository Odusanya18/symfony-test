<b>Test Project 2:</b><br>
	<i>The test project is aimed at testing knowledge of best practices, anti-patterns and basic understanding
	of symfony and the likes... It strongly embraces concepts such as modularity, service registration, abstraction,
	dependency injection and many other practices associated with OOP and other professional design practices.
	In-code documentation is provided with phpDocs.
	The project is a simple film inventory system.</i>

<b>Getting Started:</b><br>
	Extract the files and delete the files under @app/DoctrineMigrations, it is absolutely not needed but only provides
	the equivalent of a MySQL git. Open a terminal in the home directory.

<b>Prerequisites:</b><br>
	1. Php version >= 5.5.9 <br>
	2. Composer <br>
	3. MySQL server or MariaDB <br>
	4. Attention <br>



<b>About:</b>
	The test project was setup using the latest symfony version 3.3.5 .
	The default ORM is doctrine(laravel's eloquent equivalent), and uses doctrine's
	migrations equivalent for migrations and doctrine's fixtures for fixtures('laravel seeder equivalent')

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


<b>Notes:</b><br>

	1.Symfony 3.3.5 is not yet stable, even though it's marked stable, I personally encountered issues when integrating
	bundles not yet adapted for version 3.3.5<br>

	2.Console command<br>

		<p>./bin/console server:start</p>

	is non-blocking and doesn't work on Mac systems where such isn't supported, so use<br>

		<p>php bin/console server:run</p>

	3.Console commands as described above prefixed with<br>

		<p>./</p> as in <p>./bin/console ....</p>

	  only works on linux, prefix with<br>

	  	<p>php </p> instead, as in <p> php bin/console ....</p>

	  on Mac and Windows Systems.<br>

	4.For more administrational activities, the admin panel is located @localhost:8000/admin<br>

<b>Coding standard:</b><br>
	The project adheres to the following coding standards:<br>
		PSR-1<br>
		PSR-2<br>
		PSR-4<br>
		PSR-5<br>
		PSR-12.<br>

<b>Built With:</b><br>
	1.Php<br>
	2.Symfony<br>
	3.Composer<br>

<b>Authors:</b><br>
	-Odusanya Victor -	<i>Initial work</i>
