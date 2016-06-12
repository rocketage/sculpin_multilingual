<?php

namespace Rocketage\Sculpin\Bundle\MultilingualBundle;

use Sculpin\Core\Sculpin;
use Sculpin\Core\Event\SourceSetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Multilingual Generator.
 */
class MultilingualGenerator implements EventSubscriberInterface
{
    private $sharedDirectoryPattern;
    private $targetDirectories;

    public function __construct($sharedDirectory, array $targetDirectories)
    {
        $this->sharedDirectoryPattern = sprintf('/^%s/', preg_quote($sharedDirectory));
        $this->targetDirectories = $targetDirectories;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Sculpin::EVENT_BEFORE_RUN => 'beforeRun',
        );
    }

    /**
     * @param SourceSetEvent $sourceSetEvent
     */
    public function beforeRun(SourceSetEvent $sourceSetEvent)
    {
        $sourceSet = $sourceSetEvent->sourceSet();

        foreach ($sourceSet->updatedSources() as $source) {

            $sourcePath = $source->relativePathname();

            if ($source->isGenerated() || !preg_match($this->sharedDirectoryPattern, $sourcePath)) {
                continue;
            }

            foreach ($this->targetDirectories as $target) {

                $id = $source->sourceId() . ':' . $target;
                $targetPath = preg_replace($this->sharedDirectoryPattern, $target, $sourcePath);

                $generatedSource = $source->duplicate($id, ['relativePathname' => $targetPath]);
                $generatedSource->setIsGenerated();
                $sourceSet->mergeSource($generatedSource);

            }

            $source->setShouldBeSkipped();
        }
    }
}
