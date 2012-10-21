<?php

namespace Emicro\Bundles\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TemplateCommand extends ContainerAwareCommand
{
    private $bundle;

    protected function configure()
    {
        $this->setName('generate:template');
        $this->setDescription('Re-generate the javascript template file.');
        $this->addOption('watch', null, InputOption::VALUE_NONE, 'Check for changes every second, debug mode only');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('watch')) {
            $this->dumpTemplate($input, $output);
            return;
        }

        $this->watch($input, $output);
    }

    private function watch(InputInterface $input, OutputInterface $output)
    {
        while (true) {
            $bundle = $this->bundleTemplate();
            if ($bundle != $this->bundle) {
                $this->dumpTemplate($input, $output);
            }
            sleep(1);
        }
    }

    private function dumpTemplate(InputInterface $input, OutputInterface $output)
    {
        $this->bundle = $this->bundleTemplate();
        file_put_contents('./app/Resources/js/Templates.js', $this->bundle);
        $output->writeln(sprintf('<comment>%s</comment> Generating the template file: <info>Templates.js</info>', date('H:i:s')));
    }

    private function bundleTemplate()
    {
        $dirIterator = new \DirectoryIterator('./app/Resources/templates');

        $bundle = "Templates = {};\n";
        foreach ($dirIterator as $file) {
            if ($file->isFile()) {
                $html = $this->bundleHtml($file->getPathname());
                $bundle .= "Templates." . $file->getBasename('.html') . " = '" . $html . "';\n";
            }
        }

        return $bundle;
    }

    private function bundleHtml($file)
    {
        $html = file_get_contents($file);

        $html = str_replace(array("\r\n", "\n", "\r"), " ", $html);
        $html = str_replace("'", "\\'", $html);
        $html = preg_replace("/\s+/", " ", $html);

        return $html;
    }
}