<?php

/**
 * Created by PhpStorm.
 * User: sokolskih
 * Date: 17.07.2017
 * Time: 14:52
 */
class AmoDeals
{
    /*
    function getDeal($dealId){
        global $subdomain;

        $link='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/leads/list?limit_rows=1&id='.$dealId;

        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code=(int)$code;
        $errors=array(
            301=>'Moved permanently',
            400=>'Bad request',
            401=>'Unauthorized',
            403=>'Forbidden',
            404=>'Not found',
            500=>'Internal server error',
            502=>'Bad gateway',
            503=>'Service unavailable'
        );
        try
        {
            #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if($code!=200 && $code!=204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        }
        catch(Exception $E)
        {
            die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        }
        return $out;
    }

*/

    function getDeals($countDealsinAmoCRM)
    {
        global $subdomain;

        if ($countDealsinAmoCRM > 500) {
            echo "скрипт обрабатывает не более 500 сделок";
            exit();
        } else {
            $count_rows = $countDealsinAmoCRM;
        }

        $start_rows = 0;

        $link = 'https://' . $subdomain . '.amocrm.ru/private/api/v2/json/leads/list?limit_rows=' . $count_rows . '&limit_offset=' . $start_rows;

        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE,
            $_SERVER["DOCUMENT_ROOT"] . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR,
            $_SERVER["DOCUMENT_ROOT"] . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
            #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }

        $out = json_decode($out);

        $dealsArray = [];

        for ($j = 0; $j < $count_rows; $j++) {
            // echo 'j:'.$j." id:".$out->response->leads[$j]->id." name:".$out->response->leads[$j]->name." status_id:".$out->response->leads[$j]->status_id."<br>";
            if ($out->response->leads[$j]->id == null) {
                break;
            }
            $deal = new Deal();
            $deal->id = $out->response->leads[$j]->id;
            $deal->name = $out->response->leads[$j]->name;
            $deal->status_id = $out->response->leads[$j]->status_id;
            $dealsArray[] = $deal;
        }
        return $dealsArray;
    }


}