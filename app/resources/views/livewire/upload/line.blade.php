{{--
  @var object $addons addons values
  or
  @var array $defaults image default addons values
--}}
<textarea name="caption" disabled><?= isset($addons) ? $addons->caption : $defaults['caption'] ?></textarea>
