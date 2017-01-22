<?php
/* Made By Thunder33345 */
namespace Thunder33345\PureChatExtension;

use _64FF00\PureChat\PureChat;
use onebone\economyapi\EconomyAPI;
use pocketmine\plugin\PluginBase;
use Thunder33345\PureChatExtension\Tags\EconomyAPITag;

class Loader extends PluginBase
{
  public function onLoad()
  {
    @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
  }

  public function onEnable()
  {
    /** @var PureChat $pc */
    $pc = $this->getServer()->getPluginManager()->getPlugin("PureChat");
    if ($pc !== null) {
      if (!method_exists($pc, "registerCustomTag") OR !method_exists($pc, "applyCustomTags")) {
        $this->getLogger()->alert("Incorrect/Incompatible Version Detected");
        $this->getPluginLoader()->disablePlugin($this);
      }
    } else {
      $this->getLogger()->alert("Failed to load PureChat");
      $this->getPluginLoader()->disablePlugin($this);
    }
    $tags = $this->getConfig()->get('tags');
    foreach ($tags as $tag) {
      $tag = strtolower($tag);
      switch ($tag) {
        case "economyapi":
          if (EconomyAPI::getInstance() !== null) {
            if (!$pc->registerCustomTag(new EconomyAPITag(), true, $detail))
              $this->getLogger()->notice("Failed to add EconomyAPI tag\n" . print_r($detail . true) . "\n");
            else $this->getLogger()->notice("Successfully registered EconomyAPI tag");
          } else $this->getLogger()->notice("Failed to load EconomyAPI!\n");
      }
    }
  }

  public function onDisable()
  {

  }

  /** @return PureChat */
  private function getPureChat()
  {
    $pc = $this->getServer()->getPluginManager()->getPlugin("PureChat");
    if ($pc instanceof PureChat) return $pc; else return null;
  }
}