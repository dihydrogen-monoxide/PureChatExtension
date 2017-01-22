<?php
/* Made By Thunder33345 */
namespace Thunder33345\PureChatExtension\Tags;
/**
 * @name EconomyAPI
 * @website https://github.com/onebone/EconomyS
 */
use _64FF00\PureChat\Tags\CustomTagInterface;
use onebone\economyapi\EconomyAPI;
use pocketmine\Player;

class EconomyAPITag implements CustomTagInterface
{
  public function getApi() { return EconomyAPI::getInstance(); }

  public function onAdd() { }

  public function onRemove($code = 0) { }

  public function onError($code) { }

  public function getPrefix(): string { return "ecoapi"; }

  public function getAllTags(): array
  {
    return [
      "mymoney" => "myMoney",
    ];
  }

  public function myMoney(Player $player) { return $this->getApi()->myMoney($player); }
}