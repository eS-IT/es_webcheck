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
 * @author     Patrick Froch <patrick.froch@easySolutionsIT.de/>
 * @package    Language
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_es_webcheck']['name']       = array('Bezeichnung', 'Kurze Beschreibung der zu testenden Seite');
$GLOBALS['TL_LANG']['tl_es_webcheck']['url']        = array('Adresse', 'Adresse der zu testenden Seite. Eingabe ohne Protokoll (z.B. http://)!');
$GLOBALS['TL_LANG']['tl_es_webcheck']['teststring'] = array('Teststring', 'Der Text, der auf der zu testenden Seite gesucht werden soll (HTML-Tags werden heraus gefiltert).');
$GLOBALS['TL_LANG']['tl_es_webcheck']['added']      = array('Erstellt am', 'Erstellungsdatum des WebCkeck-Auftrages');
$GLOBALS['TL_LANG']['tl_es_webcheck']['source']     = array('Antwort des Servers', 'Der Antwortstring, den der Server auf die Anfrage gesendet hat.');
$GLOBALS['TL_LANG']['tl_es_webcheck']['date']       = array('Testdatum', 'Datum des letzten Tests');
$GLOBALS['TL_LANG']['tl_es_webcheck']['time']       = array('Testzeit', 'Uhrzeit des letzten Tests');
$GLOBALS['TL_LANG']['tl_es_webcheck']['reachable']  = array('Erreichbarkeit', 'Ergebnis des letzten Tests');


/**
 * Legenden
 */
$GLOBALS['TL_LANG']['tl_es_webcheck']['legend']     = 'WebCheck';
$GLOBALS['TL_LANG']['tl_es_webcheck']['legend-admin']= 'Datum und Zeit';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_es_webcheck']['new']        = array('Neuer WebCheck', 'Eine neuen WebCheck eingeben');
$GLOBALS['TL_LANG']['tl_es_webcheck']['edit']       = array('WebCkeck bearbeiten', 'WebCkeck mit der ID %s zum Bearbeiten öffnen');
$GLOBALS['TL_LANG']['tl_es_webcheck']['copy']       = array('WebCkeck kopieren', 'WebCkeck mit der ID %s  kopieren.');
$GLOBALS['TL_LANG']['tl_es_webcheck']['delete']     = array('WebCkeck löschen', 'WebCkeck mit der ID %s löschen.');
$GLOBALS['TL_LANG']['tl_es_webcheck']['show']       = array('WebCkeck anzeigen', 'WebCkeck mit der ID %s anzeigen.');
$GLOBALS['TL_LANG']['tl_es_webcheck']['checkall']   = array('Alle Server testen', 'Prüft die Erreichbarkeit aller Server.');


?>