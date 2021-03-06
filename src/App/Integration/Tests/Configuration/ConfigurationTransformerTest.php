<?php

namespace App\Integration\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;
use App\Integration\Configuration\Configuration;
use App\Integration\Configuration\ConfigurationTransformer;
use Component\Entity\Achievement\ActionDefinition;
use Component\Entity\Achievement\AchievementDefinition;
use Component\Entity\Achievement\Level;

class ConfigurationTransformerTest extends TestCase
{
    public function test_transform_from_file(): void
    {
        $file = sprintf('%s/Fixture/%s.yml', __DIR__, __FUNCTION__);
        $config = Yaml::parse(file_get_contents($file));

        $transformer = new ConfigurationTransformer(new Processor(), new Configuration());
        $configs = $transformer->transformFromUnprocessedConfig($config);

        $this->assertArrayHasKey('services.yml', $configs);
        $this->assertArrayHasKey('entities.yml', $configs);

        $this->assertArrayHasKey(ActionDefinition::class, $configs['entities.yml']);
        $this->assertArrayHasKey(AchievementDefinition::class, $configs['entities.yml']);
        $this->assertArrayHasKey(Level::class, $configs['entities.yml']);
        $this->assertArrayHasKey('services', $configs['services.yml']);
        $this->assertArrayHasKey('_defaults', $configs['services.yml']['services']);

        foreach ($configs['entities.yml'][ActionDefinition::class] as $action) {
            $this->assertArrayHasKey('__construct', $action);
            $this->assertArrayHasKey('label', $action);
            $this->assertArrayHasKey('description', $action);
            $this->assertArrayHasKey('imageUrl', $action);
        }

        foreach ($configs['entities.yml'][AchievementDefinition::class] as $achievement) {
            $this->assertArrayHasKey('__construct', $achievement);
            $this->assertArrayHasKey('__calls', $achievement);
            $this->assertArrayHasKey('label', $achievement);
            $this->assertArrayHasKey('description', $achievement);
            $this->assertArrayHasKey('points', $achievement);
            $this->assertArrayHasKey('imageUrl', $achievement);
        }

        foreach ($configs['entities.yml'][Level::class] as $level) {
            $this->assertArrayHasKey('__construct', $level);
            $this->assertArrayHasKey('label', $level);
            $this->assertArrayHasKey('description', $level);
            $this->assertArrayHasKey('imageUrl', $level);
        }

        foreach ($configs['services.yml']['services'] as $name => $service) {
            if ('_defaults' === $name) {
                continue;
            }
            $this->assertArrayHasKey('class', $service);
            $this->assertArrayHasKey('arguments', $service);
            $this->assertArrayHasKey('tags', $service);
        }
    }
}
