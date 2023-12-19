{{--
  @var object $addons addons values
  or
  @var array $defaults image default addons values
--}}
<span class="line">
  <input name="year" placeholder="year" type="text" readonly value="<?= isset($addons) ? $addons->year : $defaults['year'] ?>" />
  <select name="category" readonly>
    <option value='home' <?= isset($addons) ? ($addons->category == 'home' ? 'selected' : '') : 'selected' ?>>
      home
    </option>
    <option value='office' <?= isset($addons) ? ($addons->category == 'office' ? 'selected' : '') : '' ?>>
      office
    </option>
  </select>
  <textarea name="caption" placeholder="caption" readonly><?= isset($addons) ? $addons->caption : $defaults['caption'] ?></textarea>
</span>