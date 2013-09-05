<?php

// This is library code. Depending on whether composer install was ran, we may have our own vendor directory
// that should setup an autoloader for us. Look for that first. Chances are, we might be running these tests from
// within another project that has installed this library through composer. So as a last ditch effort, let's jump
// up a bunch of directories and see if we can find the vendor directory of that project.

// NOTE: Jumping up to a parent project vendor directory would allow us to do stupid things, like test classes
// that don't exist in our project, simply because we used a parent project's autoloader, and said parent project
// may require other things. This would be bad. Don't do that.

$project = realpath(__DIR__ . '/../vendor/autoload.php');
$parentProject = realpath(__DIR__ . '/../../../../vendor/autoload.php');

if (file_exists($project)) {
    require $project;
} elseif (file_exists($parentProject)) {
    require $parentProject;
} else {
    throw new \Exception('Dude, you have no vendor.');
}
