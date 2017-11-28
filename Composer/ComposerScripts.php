<?php
namespace Composer;

use Composer\EventDispatcher\Event;

class ComposerScripts {

	protected static function slug($str) {
		return strtolower(preg_replace('/[^\w]+/', '-', $str));
	}

	public static function preCreate(Event $event) {
		$io = $event->getIO();
		$vars = static::askQuesions($io);
		static::findFiles($vars);
		static::addStubs($vars);
	}

	public static function addStubs($vars) {
		$stubDir = dirname(__DIR__) . '/stubs';
		static::addIndexStub($stubDir . '/index', $vars);
	} 

	protected static function addIndexStub($stubPath, $vars) {
		$pluginPath = dirname(__DIR__) . '/' . static::slug($vars['PluginName']) . '.php';
		$content = static::replaceVars($stubPath, $vars);
		file_put_contents($pluginPath, $content);
	}

	protected static function findFiles($vars) {
		$self = basename(__FILE__);
		foreach(glob('*.php') as $fileName) {
			if(strpos( $fileName, $self ) !== false) {
				continue;
			}
			$content = static::replaceVars($fileName, $vars);
			file_put_contents($fileName, $content);
		}
	}

	protected static function replaceVars($file, $vars) {
		return implode('', array_map(function($line) use($vars) {
			return preg_replace_callback('/\/\*\[(.+)\]\*\//', function($match) use($vars) {
				if($match && isset($vars[$match[1]])) {
					return $vars[$match[1]];
				}
			}, $line);
		}, file($file)));
	}

	protected function cleanup() {
		$files = [ 'stubs/index', 'Composer/ComposerScripts.php', 'composer.json' ];
		foreach($files as $file) {
			@unlink($file);
		}
	}

	protected static function askQuesions($io) {
		$currentAuthor = get_current_user();
		$PluginName = $io->ask("Plugin Name [WordPress.org Plugin]: ", "WordPress.org Plugin");

		$PluginUrl = $io->ask('Plugin URL: ');

		$Description = $io->ask('Description: ');

		$Version = $io->ask('Version [0.1]: ', '0.1');

		$Author = $io->ask("Author [{$currentAuthor}]: ", $currentAuthor);

		$AuthorUrl = $io->ask('Author URL: ');

		$PHPVersion = $io->ask('Requires at least [5.3]: ', '5.3');

		$PHPtestedVersion = $io->ask('Tested up to [5.3]: ', '5.3');

		$TextDomain = $io->ask('Text Domain: ');
		$DomainPath = $io->ask('Domain Path: ');

		$defaultNamespace = implode('\\', array_map('ucfirst', preg_split('/[^\w]+/', $PluginName)));

		$Namespace = $io->ask("Namespace {$defaultNamespace}: ", $defaultNamespace);

		if(!substr($Namespace, -1) !== '\\') {
			$Namespace .= '\\';
		}

		return compact(
			'PluginName',
			'PluginUrl',
			'Description',
			'Version',
			'Author',
			'AuthorUrl',
			'PHPVersion',
			'PHPtestedVersion',
			'TextDomain',
			'DomainPath'
		);
	}
}
