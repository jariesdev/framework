<?php

namespace AvoRed\Framework\Modules;

use RecursiveIteratorIterator;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Collection;
use League\Flysystem\MountManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class Manager
{
    /**
     * existing module list
     * @var array $moduleList
     */
    public $moduleList;

    /**
     * existing files list
     * @var array $files
     */
    public $files;

    /**
     * Flag for is Module is loaded or not
     * @var bool $moduleLoaded
     */
    public $moduleLoaded = false;

    /**
     * Construct for the module manager
     * @param \Illuminate\Filesystem\Filesystem $fileSystem
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->moduleList = Collection::make([]);
    }

    /**
     * Get all the moduleList Collection
     * @return \Illuminate\Support\Collection $moduleList
     */
    public function all()
    {
        if ($this->moduleLoaded === false) {
            $this->loadModules();
        }

        return $this->moduleList;
    }

    /**
     * Scan Module Path and load into a moduleList Collection
     * @return self $this
     */
    protected function loadModules()
    {
        $modulePath = base_path('modules');

        if (File::exists($modulePath)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($modulePath, RecursiveDirectoryIterator::FOLLOW_SYMLINKS)
            );

            $iterator->setMaxDepth(2);
            $iterator->rewind();

            while ($iterator->valid()) {
                if (($iterator->getDepth() > 1) &&
                    $iterator->isFile() &&
                    ($iterator->getFilename() == 'register.yml')) {
                    $filePath = $iterator->getPathname();
                    $moduleRegisterContent = File::get($filePath);
                    $data = Yaml::parse($moduleRegisterContent);

                    $module = new Module();
                    $module->namespace($data['namespace']);
                    $module->identifier($data['identifier']);
                    $module->name($data['name']);
                    $module->status($data['status']);
                    $module->description($data['description']);
                    $module->basePath($iterator->getPath());
                    $module->publishedTags($data['published_tags'] ?? []);

                    $composerLoader = require base_path('vendor/autoload.php');
                    if (strtolower($module->status()) == 'active') {
                        $path = $iterator->getPath() . DIRECTORY_SEPARATOR . 'src';
                        $composerLoader->addPsr4($module->namespace(), $path);
                        $moduleProvider = $module->namespace() . 'Module';
                        App::register($moduleProvider);
                    }

                    $this->moduleList->put($module->identifier(), $module);
                }
                $iterator->next();
            }

            $this->moduleLoaded = true;
        }

        return $this;
    }

    /**
     * Put Module Info to a collection
     * @param string $identifier
     * @param array $moduleInfo
     * @return self $this
     */
    public function put($identifier, $moduleInfo)
    {
        $this->moduleList->put($identifier, $moduleInfo);

        return $this;
    }

    /**
     * Get Module by identifier
     * @param string $identifier
     * @return \AvoRed\Framework\Modules\Module $module
     */
    public function get($identifier)
    {
        if ($this->moduleLoaded === false) {
            $this->loadModules();
        }

        return $this->moduleList->pull($identifier);
    }

    /**
     * Get Module by Path
     * @param string $path
     * @return \AvoRed\Framework\Modules\Module $module
     */
    public function getByPath($path)
    {
        foreach ($this->moduleList as $module => $moduleInfo) {
            $path1 = $this->pathSlashFix($path);
            $path2 = $this->pathSlashFix($moduleInfo['path']);

            if ($path1 == $path2) {
                $actualModule = $this->moduleList[$module];
                break;
            }
        }

        return $actualModule;
    }

    /**
     * Publish an item to given path from passed path
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function publishItem($from, $to)
    {
        if ($this->files->isDirectory($from)) {
            return $this->publishDirectory($from, $to);
        }

        throw new \Exception("Can't locate path: <{$from}>");
    }

    /**
     * Publish the directory to the given directory.
     * @param  string $from
     * @param  string $to
     * @return void
     */
    protected function publishDirectory($from, $to)
    {
        $this->moveManagedFiles(new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to' => new Flysystem(new LocalAdapter($to)),
        ]));
    }

    /**
     * Move all the files in the given MountManager.
     * @param  \League\Flysystem\MountManager $manager
     * @return void
     */
    protected function moveManagedFiles($manager)
    {
        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (!$manager->has('to://' . $file['path']))) {
                $manager->put('to://' . $file['path'], $manager->read('from://' . $file['path']));
            }
        }
    }

    /**
     * Slash the given path
     * @param string $path
     * @return string $slashPath
     */
    protected function pathSlashFix($path)
    {
        return (DIRECTORY_SEPARATOR === '\\') ? str_replace('/', '\\', $path) : str_replace('\\', '/', $path);
    }
}
