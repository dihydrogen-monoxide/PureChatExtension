<?php
/* Made By Thunder33345 */
namespace Thunder33345\PureChatExtension\Tags;

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