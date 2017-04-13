<?php
/* Made By Thunder33345 */

/**
 * @name FactionsPE
 * @website https://github.com/BlockHorizons/FactionsPE
 */

namespace Thunder33345\PureChatExtension\Tags\Factions;

use _64FF00\PureChat\Tags\CustomTagInterface;
use factions\entity\OfflineMember;
use factions\manager\Factions;
use factions\manager\Members;
use factions\relation\Relation;
use pocketmine\Player;

class FactionsPETag implements CustomTagInterface,FactionInterface
{
  private $config;

  public function __construct($config)
  {
    $this->config = $config;
  }

  public function onAdd() { }

  public function onRemove($code = 0) { }

  public function onError($code) { }

  public function getPrefix(): string { return "factionpe"; }

  public function getAllTags(): array
  {
    $ret = [
     "fname" => "getFactionName",
     "rank" => "getPlayerFactionRank",
     "ppower" => "getPlayerPower",
     "ppowerl" => "getPlayerPowerL",//*shrugs*
     "fpower" => "getFactionPower",
     "fpowerl" => "getFactionPowerL",//*shrugs*
     "fbank" => "getFactionBank",
    ];
    return $ret;
  }

  public function getFactionName(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['name']['none'];
    }
    if(($fac = Factions::getById($member->getFactionId())) === null) {
      return $this->config['name']['none'];
    }//no fac
    return str_replace("%name%",$fac->getName(),$this->config['name']['exist']);
  }

  public function getPlayerFactionRank(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['rank']['none'];
    }
    if(($fac = Factions::getById($member->getFactionId())) === null) {
      return $this->config['rank']['none'];
    }//no fac
    switch($fac->getRole($member)){
      case Relation::RECRUIT;
        return $this->config['rank']['recruit'];
      case Relation::MEMBER;
        return $this->config['rank']['member'];
      case Relation::OFFICER;
        return $this->config['rank']['officer'];
      case Relation::LEADER;
        return $this->config['rank']['leader'];
      default:
        return $this->config['rank']['none'];
    }
  }

  public function getPlayerPower(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['power']['none'];
    }
    $pow = $member->getPower(false);
    return str_replace("%power%",$pow,$this->config['power']['power']);
  }

  public function getPlayerPowerL(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['power']['none'];
    }
    $pow = $member->getPower(false);
    return str_replace("%power%",$pow,$this->config['power']['power']);
  }

  public function getFactionPower(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['power']['none'];
    }
    if(($fac = Factions::getById($member->getFactionId())) === null) {
      return $this->config['power']['none'];
    }
    $pow = $fac->getPower(false);
    return str_replace("%power%",$pow,$this->config['power']['power']);
  }

  public function getFactionPowerL(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['power']['none'];
    }
    if(($fac = Factions::getById($member->getFactionId())) === null) {
      return $this->config['power']['none'];
    }
    $pow = $fac->getPower(true);
    return str_replace("%power%",$pow,$this->config['power']['power']);
  }

  public function getFactionBank(Player $player)
  {
    $member = Members::get($player);
    if(!$member instanceof OfflineMember) {
      return $this->config['bank']['none'];
    }
    if(($fac = Factions::getById($member->getFactionId())) === null) {
      return $this->config['bank']['none'];
    }
    $bank = $fac->getBank();
    return str_replace("%bank%",$bank,$this->config['bank']['bank']);
  }
}
