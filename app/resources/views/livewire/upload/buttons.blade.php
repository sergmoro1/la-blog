<a href="javascript:;" class="button small green" id="btn-edit" 
    title="{{ __('Open the image fields for editing') }}"
    onclick="imageLine.edit(this);">
    <span class="material-icons">edit</span>
</a>
<a href="javascript:;" class="button small red" id="btn-delete" 
    title="{{ __('Delete image') }}"
    onclick="imageLine.delete(this);">
    <span class="material-icons">delete</span>
</a>
<a href="javascript:;" class="button small blue inactive" id="btn-save" 
    title="{{ __('Save additional image fields') }}"
    onclick="imageLine.save(this);">
    <span class="material-icons">save</span>
</a>
<a href="javascript:;" class="button small inactive" id="btn-cancel" 
    title="{{ __('Undo the editing results') }}"
    onclick="imageLine.cancel(this);">
    <span class="material-icons">cancel</span>
</a>