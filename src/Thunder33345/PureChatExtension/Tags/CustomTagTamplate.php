<?php
/* Made By Thunder33345 */
namespace Thunder33345\PureChatExtension\Tags;
/** //use for other developer/maintainer to get a refrence of where the supported plugin origin from
 * @name "Supporting plugin's name"
 * @website OFFICIAL plugin's website (prefering github if avaliable)
 */
use _64FF00\PureChat\Tags\CustomTagInterface;

class CustomTagTamplate implements CustomTagInterface
{
  public function onAdd() { }

  public function onRemove($code = 0) { }

  public function onError($code) { }

  public function getPrefix(): string { return ""; }

  public function getAllTags(): array
  {
    return [];
  }
}