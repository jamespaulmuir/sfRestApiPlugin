<?php
/**
 * Gets the request body, parses and stores it in the request
 * @author James Muir <muir.29@osu.edu>
 */
class putDataFilter extends sfFilter
{
    public function execute ($filterChain)
    {
        $inputData = array();
        $context = $this->getContext();
        $request = $context->getRequest();
        
        if(!in_array($request->getMethod(), array('POST','PUT'))){
            $filterChain->execute();
            return;
        }
        $RAWinput = file_get_contents("php://input");
        $server = $_SERVER;
        if(isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'],'form-urlencoded') > -1){
            parse_str($RAWinput, $inputData);
        }
        // @TODO this is assumed that if not form urlencoded input, then json.
        else {
            $inputData = json_decode($RAWinput, true);
        }
        if(isset($inputData['data'])){
            $inputData = $inputData['data'];
        }

        if(isset($inputData['id'])){
            unset($inputData['id']);
        }
        if(isset($inputData['href'])){
            unset($inputData['href']);
        }
        if(isset($inputData['created_at'])){
            unset($inputData['created_at']);
            //$inputData['created_at'] = $this->dateParseFromFormat('Y-m-d H:i', $inputData['created_at']);
        }
        if(isset($inputData['updated_at'])){
            unset($inputData['updated_at']);
            //$inputData['updated_at'] = $this->dateParseFromFormat('Y-m-d H:i', $inputData['updated_at']);
        }

        $request->addRequestParameters(
            array(
                'inputData'=>$inputData,
                'RAWinput'=>$RAWinput
        ));
    $context->getLogger()->debug("RawInput: $RAWinput");
    $context->getLogger()->debug("inputData: ".print_R($inputData,true));
        $filterChain->execute();
    }

    /**
     * 
     * @param string $stFormat
     * @param array $stData
     * @return array
     */
    protected function dateParseFromFormat($stFormat, $stData)
    {
        $aDataRet = array();
        $aPieces = split('[:/.\ \-]', $stFormat);
        $aDatePart = split('[:/.\ \-]', $stData);
        foreach($aPieces as $key=>$chPiece)
        {
            switch ($chPiece)
            {
                case 'd':
                case 'j':
                    $aDataRet['day'] = $aDatePart[$key];
                    break;

                case 'F':
                case 'M':
                case 'm':
                case 'n':
                    $aDataRet['month'] = $aDatePart[$key];
                    break;

                case 'o':
                case 'Y':
                case 'y':
                    $aDataRet['year'] = $aDatePart[$key];
                    break;

                case 'g':
                case 'G':
                case 'h':
                case 'H':
                    $aDataRet['hour'] = $aDatePart[$key];
                    break;

                case 'i':
                    $aDataRet['minute'] = $aDatePart[$key];
                    break;

                case 's':
                    $aDataRet['second'] = $aDatePart[$key];
                    break;
            }

        }
        return $aDataRet;
    }

}