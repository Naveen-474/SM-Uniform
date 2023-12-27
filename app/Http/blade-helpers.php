<?php
function formButtons($submitButton = 'Submit')
{
    $currentRoute = Illuminate\Support\Facades\Route::currentRouteName();
    return '<div style="margin-top: 20px;" class="text-end">
                    <a href="'. route($currentRoute) .'" class="btn rounded-pill btn-warning">Clear</a>
                    <a href="#" class="btn rounded-pill btn-danger">Cancel</a>
                    <button type="submit" class="btn rounded-pill btn-success">
                      ' . $submitButton . '
                    </button>
                </div>';
}
