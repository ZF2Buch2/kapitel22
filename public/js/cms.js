function cmsEditContentBlock(block) {
    document.getElementById(block + "_uneditable").style.display = "none";
    document.getElementById(block).style.display = "block";
    document.getElementById("cms_edit_" + block).disabled = "disabled";
    document.getElementById("cms_save_" + block).disabled = false;
    document.getElementById("cms_cancel_" + block).disabled = false;
    document.getElementById(block).focus();
}

function cmsCancelContentBlock(block) {
    document.getElementById(block + "_uneditable").style.display = "block";
    document.getElementById(block).style.display = "none";
    document.getElementById("cms_edit_" + block).disabled = false;
    document.getElementById("cms_save_" + block).disabled = "disabled";
    document.getElementById("cms_cancel_" + block).disabled = "disabled";
}

function cmsSaveContentBlock(block) {
    var form = document.getElementById("block_" + block);
    form.content.value = CKEDITOR.instances[block].getData();
    form.submit();
}