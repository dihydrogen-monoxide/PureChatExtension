<?php
/* Made By Thunder33345 */
namespace Thunder33345\PureChatExtension\Tags\Factions;

use _64FF00\PureChat\Tags\CustomTagInterface;
use pocketmine\Player;
use pocketmine\Server;

class GenericFactionTag implements CustomTagInterface, FactionInterface
{
  /** @var  Server */
  private $server;
  private $config;
  private $tags;

  public function __construct(Server $server, $config, $tags)
  {
    $this->server = $server;
    $this->config = $config;
    $this->tags = $tags;
  }

  private function getAPI()
  {
    return $this->server->getPluginManager()->getPlugin($this->config['plugin_name']);
  }

  public function onAdd() { }

  public function onRemove($code = 0) { }

  public function onError($code) { }

  public function getPrefix(): string { return "faction"; }

  public function getAllTags(): array
  {
    $ret = [];//hopes empty ret wont break anything....
    foreach ($this->tags as $tag) {
      switch ($tag) {
        case "name":
          $ret["name"] = "getFactionName";
          break;
        case "rank":
          $ret["rank"] = "getPlayerRank";
          break;
        case "power":
          $ret["power"] = "getFactionPower";
          break;
      }
    }
    return $ret;
  }

  public function getFactionName(Player $player)
  {
    $name = $this->getAPI()->getPlayerFaction($player->getName());
    if (strlen($name) <= 0) {
      return $this->config['name']['none'];
    } else {
      return str_replace("%name%", $name, $this->config['name']['exist']);
    }
  }

  public function getPlayerRank(Player $player)
  {
    if ($this->getAPI()->isInFaction($player->getName())) {
      if ($this->getAPI()->isMember($player->getName())) {
        return $this->config['rank']['member'];
      } elseif ($this->getAPI()->isOfficer($player->getName())) {
        return $this->config['rank']['officer'];
      } elseif ($this->getAPI()->isLeader($player->getName())) {
        return $this->config['rank']['leader'];
      } else return $this->config['rank']['none'];//unreachable but good measure
    } else return $this->config['rank']['none'];
  }

  public function getFactionPower(Player $player)
  {
    $faction = $this->getAPI()->getPlayerFaction($player->getName());
    if (strlen($faction) <= 0) {
      return $this->config['power']['none'];
    }
    return str_replace("%power%", $this->getAPI()->getFactionPower($faction), $this->config['power']['exist']);
  }
}