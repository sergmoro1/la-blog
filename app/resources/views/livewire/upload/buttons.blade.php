<a href="javascript:;">
    <button  class="button small green" id="btn-edit" type="button"
        title="{{ __('Open the image fields for editing') }}"
        onclick="imageLine.edit(this);">
        <span class="material-icons">edit</span>
    </button>
</a>
<a href="javascript:;">
    <button  class="button small red" id="btn-delete" type="button"
        title="{{ __('Delete image') }}"
        onclick="imageLine.delete(this);">
        <span class="material-icons">delete</span>
    </button>
</a>
<a href="javascript:;">
        <button class="button small blue inactive" id="btn-save" type="button"
        title="{{ __('Save additional image fields') }}"
        onclick="imageLine.save(this);">
        <span class="material-icons">save</span>
    </button>
</a>
<a href="javascript:;">
        <button class="button small inactive" id="btn-cancel" type="button"
        title="{{ __('Undo the editing results') }}"
        onclick="imageLine.cancel(this);">
        <span class="material-icons">cancel</span>
    </button>
</a>