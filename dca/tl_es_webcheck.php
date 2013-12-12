<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  2010 by e@sy Solutions IT <http://www.easySolutionsIT.de/>
 * @author     Patrick Froch <patrick.froch@easySolutionsIT.de>
 * @package    eS_WebCheck
 * @license    LGPL
 * @filesource
 */


$GLOBALS['TL_DCA']['tl_es_webcheck'] = array
(


    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => false
    ),


    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'flag'                    => 1,
            'fields'                  => array('name'),
            'panelLayout'             => 'filter,sort,search'
        ),
        'label' => array
        (
            'fields'                  => array('name', 'date', 'time', 'reachable'),
            'format'                  => '%s  <span style="color:#b3b3b3; padding-left:3px;">(%s - %s) </span>[%s]',
            'label_callback'          => array('es_webcheck_Setup', 'makeLable')
        ),
        'global_operations' => array
        (
             'checkall' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_es_webcheck']['checkall'],
                'href'                => 'key=checkall',
                'class'               => 'checkall'
            ),
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_es_webcheck']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_es_webcheck']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_es_webcheck']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_es_webcheck']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            ),
            'check' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_es_webcheck']['check'],
                'href'                => 'key=check',
                'icon'                => 'system/modules/es_webcheck/html/server_grey.png',
                'button_callback'     => array('es_webcheck_Setup', 'makeIcon')
            )

        )
    ),


    // Palettes
    'palettes' => array
    (
        'default'                     => '{legend}, name, url, teststring; {legend-admin:hide}, added;'
    ),


    // Fields
    'fields' => array
    (
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['name'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class' => 'w50', 'mandatory' => true)
        ),

        'url' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['url'],
            'search'                  => true,
            'inputType'               => 'text',
            'save_callback'           => array(array('es_webcheck_Setup', 'saveSettings')),
            'eval'                    => array('tl_class' => 'w50', 'mandatory' => true)
        ),

        'teststring' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['teststring'],
            'inputType'               => 'textarea',
            'eval'                    => array('tl_class' => 'long', 'mandatory' => true, 'cols' => 5, 'rows' => 4)
        ),

        'added' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['added'],
            'search'                  => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'load_callback'           => array(array('es_webcheck_Setup', 'setDate')),
            'eval'                    => array('maxlength'=>20, 'mandatory' => true, 'tl_class' => 'long')
        ),

        'source' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['source'],
            'inputType'               => 'hidden',
            'eval'                    => array('readonly' => true)
        ),

        'date' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['date'],
            'search'                  => true,
            'filter'                  => true,
            'inputType'               => 'hidden',
            'eval'                    => array('readonly' => true)
        ),

        'time' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['time'],
            'search'                  => true,
            'inputType'               => 'hidden',
            'eval'                    => array('readonly' => true)
        ),

        'reachable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_es_webcheck']['reachable'],
            'search'                  => true,
            'filter'                  => true,
            'inputType'               => 'hidden',
            'eval'                    => array('readonly' => true)
        )
    )
);


/**
 * Description:
 * Setup-Klasse fuer das eS_WebCheck-Formular.
 *
 * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
 * @copyright   Copyright 2011 by e@sy Solutions IT
 * @version     1.0.0
 * @since       29.05.2011
 * @category    eS_Tools
 * @package     eS_WebCheck
 * @uses        Contao-Framework
 */
class es_webcheck_Setup extends Backend {


    /**
     * Description:
     * Gibt das aktuelle Datum und die Uhrzeit fuer das Feld added zurueck.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       29.05.2011
     * @return      <string>    Formatierter Datum-String
     */
    public function setDate(){
        return date('Y.m.d H:i:s');
    }


    /**
     * Description:
     * Ersetzt die 1 des Felds 'reachable' durch 'Erreichbar' oder 'Nicht Erreichbar'
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       29.05.2011
     * @return      <string>    Formatierter Datum-String
     */
    public function makeLable($row, $label){
        if($row['reachable']){
            $tmp = '<span style="color:#090;">OKAY</span>';
        } elseif($row['date'] == '') {
            $tmp = '<span style="color:#666;">Noch kein Test</span>';
        } else {
            $tmp = '<span style="color:#c00;">Error</span>';
        }

        return sprintf('%s  <span style="color:#b3b3b3; padding-left:3px;">(%s - %s) </span>[%s]', $row['name'], $row['date'],$row['time'],$tmp);
    }


    /**
     * Description:
     * Entfernt ein evtl. vorhandenes http:// aus der URL. Loeschen des letzten WebCheck-Ergebnisses.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       29.05.2011
     * @return      <string>    URL ohne http://
     */
    public function saveSettings(){
        $query = 'UPDATE tl_es_webcheck SET source = "", date = "", time = "", reachable = "" WHERE id = ' . $this->Input->get('id');
        $this->Database->execute($query);

        return str_replace('http://', '', $this->Input->post('url'));

    }


    /**
     * Description:
     * Die Nethode erzeugt ein ICon in abhaengigkeit vom letzten Passwortreset. Ist weniger als 15 Minuten seit
     * dem letzten Passwort-Reset vergangen, wird ein alternatives ICon angezeigt.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       05.06.2011
     * @param       array       $arrRow                 the current row
     * @param       string      $href                   the url of the embedded link of the button
     * @param       string      $label                  label text for the button
     * @param       string      $title                  title value for the button
     * @param       string      $icon                   url of the image for the button
     * @param       array       $attributes             additional attributes for the button (fetched from the array key "attributes" in the DCA)
     * @param       string      $strTable               the name of the current table
     * @param                   $arrRootIds             array of the ids of the selected "page mounts" (only in tree view)
     * @param                   $arrChildRecordIds      ids of the childs of the current record (only in tree view)
     * @param       boolean     $blnCircularReference   determines if this record has a circular reference (used to prevent pasting of an cutted item from an tree into any of it's childs).
     * @param       string      $strPrevious            id of the previous entry on the same parent/child level. Used for move up/down buttons. Not for root entries in tree view.
     * @param       string      $strNext                id of the next entry on the same parent/child level. Used for move up/down buttons. Not for root entries in tree view.
     * @return      string                              Link for the List
     */
    public function makeIcon($arrRow, $href, $label, $title, $icon, $attributes, $strTable, $arrRootIds, $arrChildRecordIds, $blnCircularReference, $strPrevious, $strNext){
        // Die Id an den Link anfuegen
        $href  .= '&id=' . $arrRow['id'];
        $icon   = 'system/modules/es_webcheck/html/';
        $now    = time() - (60*60);     // Jetzt - 60 Min. * 60 Sek. (Letzter Test nicht aelter als 60 Min.
        $last   = strtotime($arrRow['date'] . ' ' . $arrRow['time']);

        if($arrRow['date'] == '' OR $last < $now){
            // Noch kein Test durchgeführt, oder letzter Test laenger als eine Std. her
            $icon .= 'server_grey.png';
        } else {
            if($arrRow['reachable']){
                // Server ereichbar und richtige Antwort
                $icon .= 'server_green.png';
            } else {
                if($arrRow['source'] == ''){
                    // Server nicht erreichbar
                    $icon .= 'server_red.png';
                } else {
                    // Server erreichbar, aber falsche Antwort
                    $icon .= 'server_yellow.png';
                }
            }
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
    }
}
?>