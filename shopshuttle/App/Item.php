<?php

namespace App;

class Item
{
    public function get_info()
    {
        echo "This is the ITEM-class!";
    }

    public function modalPop($cssid, $title, $content, $savebtnid = "modal-savebtn", $savelabel = "Speichern")
    {
        $ct = '<!-- Modal -->
          <div class="modal fade" id="' . $cssid . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">' . $title . '</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ' . $content . '
                </div>
                <div class="modal-footer">
                  <button id="modal-closebtn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbruch</button>
                  <button id="' . $savebtnid . '" type="button" class="btn btn-primary">' . $savelabel . '</button>
                </div>
              </div>
            </div>
          </div>';

        return $ct;
    }

    // Bootstrap Button
    public function myButton($nameID, $title, $click = "", $style = "primary")
    {
        $click_action = (!empty($click)) ? 'onclick="' . $click . '"' : '';
        return '<button name="' . $nameID . '" id="' . $nameID . '" type="button" class="btn btn-' . $style . '" ' . $click_action . '>' . $title . '</button>';
    }
}
