<?php

namespace T73Biz\PhpUnitWatcher\Screens;

class FilterGroupName extends Screen
{
    public function draw()
    {
        $this->terminal
            ->comment('Pattern mode usage')
            ->write('Type a pattern and press Enter to only run tests from a specific PHPUnit group.')
            ->write('Press Enter with an empty pattern to execute all tests in all files.')
            ->emptyLine()
            ->comment('Start typing to filter by a test name.')
            ->prompt('pattern > ');

        return $this;
    }

    public function registerListeners()
    {
        $this->terminal->on('data', function ($line) {
            if ($line == '') {
                $this->terminal->goBack();

                return;
            }

            $phpunitArguments = "--group={$line}";

            $phpunitScreen = $this->terminal->getPreviousScreen();

            $options = $phpunitScreen->options;

            $options['phpunit']['arguments'] = $phpunitArguments;

            $this->terminal->displayScreen(new Phpunit($options));
        });

        return $this;
    }
}
