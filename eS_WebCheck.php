<?php
/**
 * Description:
 * Die Klasse eS_WebCheck liesst eine externe Website ein und sucht darauf nach
 * dem angegebenen Suchtext. So wird festgestellt, ob eine Seite erreichbar ist
 * und das CMS funktioniert.
 *
 * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
 * @copyright   Copyright 2011 by e@sy Solutions IT
 * @version     1.0.0
 * @since       27.05.2011
 * @category    eS_Tools
 * @package     eS_Webiste-Check
 */


/**
 * Description:
 * Die Klasse eS_WebCheck liesst eine externe Website ein und sucht darauf nach
 * dem angegebenen Suchtext. So wird festgestellt, ob eine Seite erreichbar ist
 * und das CMS funktioniert.
 *
 * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
 * @copyright   Copyright 2011 by e@sy Solutions IT
 * @version     1.0.0
 * @since       27.05.2011
 * @category    eS_Tools
 * @package     eS_Webiste-Check
 */
class eS_WebCheck extends Backend{

    /**
     * Description:
     * Erstellt das Objekt.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       27.05.2011
     * @return      <objekt>        Gibt das erstellte Objekt zurueck
     */
    public function __construct() {
        $this->import('Database');
        $this->import('Input');
        $this->import('String');

        parent::__construct();
    }


    /**
     * Description:
     * Fuehrt die Suche fuer alle Webseiten durch. Wird kein Sourcecode zurueck gegeben, ist der Server wahrscheinlich
     * offline. Gibt es einen Sourcecode, aber nicht den Erwarteten, so funktioniert scheinbar das CMS oder die DB
     * nicht.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       05.06.2011
     * @param       <integer>   $id     Id des zu pruefenden Datensatzes
     */
    public function run($id){
        
        // Von checkall werden die Id's uebergeben, beim Einzelaufruf wird die Id aus $this->id genommen.
        if(is_object($id)){
            $id = $this->Input->get('id');
            $goBack = true;
        } else {
            $goBack = false;
        }
        
        $data = $this->loadData($id);

        if($data){
            $site   = $this->valString($data['url']);
            $search = $this->valString($data['teststring']);
            $source = $this->loadSite($site);

            $result['date']       = date('d.m.Y');
            $result['time']       = date('H:i:s');
            $result['source']     = substr($source, 0, 255);
            $result['reachable']  = $this->compareSite($source, $search);

            $this->saveData($id, $result);
            
            // Nur zurueck gehen, bei Einzelaufruf, sonst wird ueber checkall() zurueck gegangen!
            if($goBack){
                $this->returnToList($this->Input->get('do'));   // Zurueck zur Liste
            }
        }
    }


    /**
     * Description:
     * Laedt alle Id's aus der DB un ruft für alle den Check auf!
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       10.06.2011
     */
    public function checkall(){
        $result = $this->Database->execute('SELECT id FROM tl_es_webcheck');
        
        while($result->next()){
            $id = $result->id;
            $this->run($id);
        }

        $this->returnToList($this->Input->get('do'));   // Zurueck zur Liste
    }


    /**
     * Description:
     * Speichert das Ergebniss in der DB.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       05.06.2011
     * @param       <integer>       $id         Die Id des zu speichernden Datensatzes
     * @param       <array>         $result     Das Array mit den Daten, die eingetragen werden sollen
     */
    private function saveData($id, $result){
        $query = 'UPDATE tl_es_webcheck SET ';

        foreach($result as $k => $v){
            $query .= "$k = '$v', ";
        }

        $query  = substr($query, 0, strlen($query)-2);
        $query .= ' WHERE id = ?';
        
        $res    = $this->Database->prepare($query)
                                 ->execute($id);
    }


    /**
     * Description:
     * Laedt die Daten aus der DB.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       05.06.2011
     * @param       <integer>       Die des zu ladenen Datensatzes
     * @return      <mixed>         Array mit den Daten des WebCheck-Auftrages, oder FALSE im Fehlerfall.
     */
    private function loadData($id){
        $query  = 'SELECT * FROM tl_es_webcheck WHERE id = ?';
        $result = $this->Database->prepare($query)
                                 ->execute($id);
        if($result){
            return $result->fetchAssoc();
        } else {
            return false;
        }

    }


    /**
     * Description:
     * Laedt die Websiten
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       27.05.2011
     * @param       <string>    $url    Die Adresse der Seite, die abgefragt werden soll.
     * @return      <string>            Der Qeulltext der Seite.
     */
    private function loadSite($url){
        if(substr_count($url, 'http://') == 0){
            $url = 'http://' . $url;
        }

        if($source = @file_get_contents($url)){
            return $this->valString($source);
        } else {
            return false;
        }
    }


    /**
     * Description:
     * Sucht das Suchwort in der Seite
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       27.05.2011
     * @param       <string>    $source     Der Quelltext der Seite.
     * @param       <string>    $search     Das Suchwort.
     * @return      <boolean>               TRUE, wenn das Suchwort gefunden wurde, sonst FALSE
     */
    private function compareSite($source, $search){

        if($source != '' AND $search != ''){
            if(substr_count($source, $search) != 0){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * Description:
     * Die Mehtode valString bearbeitet der uebergebenen String und entfernt alle
     * HTML- u. PHP-Tags. Ausserdem werden alle Leerzeichen und Zeilenumbrueche
     * entfernt.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       27.05.2011
     * @param       <string>    $str     Der zu bearbeitende String
     * @return      <string>             Der bearbeitete String.
     */
    private function valString($str){
        $str = strtolower(strip_tags($str));
        $str = str_replace(' ', '', $str);
        $str = str_replace("\n", '', $str);
        $str = $this->String->decodeEntities($str);

        return $str;
    }


    /**
     * Description:
     * Nach dem Versenden der Zugangsdaten wird wirder auf die Uebersicht umgeleitet.
     *
     * @author      Patrick Froch (e@sy Solutions IT) <patrick.froch@easySolutionsIT.de>
     * @since       19.05.2011
     * @param       <string>    $act    Die aufgerufenen Aktion
     */
    private function returnToList($act){
        if(version_compare(VERSION . '.' . BUILD, '2.9.0', '<')) {
           $path = $this->Environment->base . 'typolight/main.php?do=' . $act;
        } else {
           $path = $this->Environment->base . 'contao/main.php?do=' . $act;
        }

        $this->redirect($path, 301);

    }
}
?>
