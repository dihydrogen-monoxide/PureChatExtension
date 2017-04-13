<?php
/* Made By Thunder33345 */
namespace Thunder33345\PureChatExtension;

use _64FF00\PureChat\PureChat;
use factions\FactionsPE;
use onebone\economyapi\EconomyAPI;
use pocketmine\plugin\PluginBase;
use Thunder33345\PureChatExtension\Tags\EconomyAPITag;
use Thunder33345\PureChatExtension\Tags\Factions\FactionsPETag;
use Thunder33345\PureChatExtension\Tags\Factions\GenericFactionTag;

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
    if($pc !== null) {
      if(!method_exists($pc,"registerCustomTag") OR !method_exists($pc,"applyCustomTags")) {
        $this->getLogger()->alert("Incorrect/Incompatible Version Detected");
        $this->getPluginLoader()->disablePlugin($this);
      }
    } else {
      $this->getLogger()->alert("Failed to load PureChat");
      $this->getPluginLoader()->disablePlugin($this);
    }
    $tags = $this->getConfig()->get('tags');
    foreach($tags as $tag){
      $tag = strtolower($tag);
      switch($tag){
        case "economyapi":
          if(EconomyAPI::getInstance() !== null) {
            if(!$pc->registerCustomTag(new EconomyAPITag(),true,$detail))
              $this->getLogger()->notice("Failed to add EconomyAPI tag\n".print_r($detail.true)."\n");
            else $this->getLogger()->notice("Successfully registered EconomyAPI tag");
          } else $this->getLogger()->notice("Failed to load EconomyAPI!\n");
          break;
        case "faction":
          $config = $this->getConfig()->get("faction");
          $fac = $this->getServer()->getPluginManager()->getPlugin($config['plugin_name']);
          if($fac === null) {
            $this->getLogger()->alert("Abort loading faction support... Cant find faction plugin, maybe try checking the name?");
            break;
          }
          $functions = [
           "name" => ["getPlayerFaction"],
           "rank" => ["isLeader","isOfficer","isMember",],
           "power" => ["getFactionPower"],
          ];
          $enable = [];
          foreach($functions as $subTag => $subFunctions){
            $disable = false;
            $requiredFunctions = "";
            foreach($subFunctions as $subFunction){
              if(!is_callable([$fac,$subFunction])) {
                $disable = true;
                $requiredFunctions .= "$subFunction ";
              }
            }
            if($disable) {
              $this->getLogger()->notice("Faction: \"$subTag\" is not supported!(\"$requiredFunctions\" missing)");
              continue;
            }
            $enable[] = $subTag;
          }
          $this->getPureChat()->registerCustomTag(new GenericFactionTag($this->getServer(),$config,$enable));
          break;
        case "factionpe":
        case "facpe":
          try{
            if(FactionsPE::get() === null) {
              $this->getLogger()->notice("Failed to load FactionPE!");
            } else {
              if(!$pc->registerCustomTag(new FactionsPETag($this->getConfig()->get("factionspe")),true,$detail))
                $this->getLogger()->notice("Failed to add EconomyAPI tag\n".print_r($detail.true)."\n");
              else $this->getLogger()->notice("Successfully registered EconomyAPI tag");
            }
          } catch(\Exception$exception){
            $this->getLogger()->notice("Failed to load FactionPE!, Debug exception incoming!");
            $this->getLogger()->logException($exception);
          }
          break;
        default:
          $this->getLogger()->notice("Tag \"$tag\" does not exist");
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
    if($pc instanceof PureChat) return $pc; else return null;
  }
}