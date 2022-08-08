<?php
      $apiurl = 'https://explorer-gql.cudos.org/v1/graphql';

      $address = $_GET['address'];
   
      $curl = curl_init();

      $fields = '{"operationName":"ValidatorDetails","variables":{"address":"'.$address.'"},"query":"query ValidatorDetails($address: String) {\n  stakingPool: staking_pool(order_by: {height: desc}, limit: 1, offset: 0) {\n    height\n    bonded: bonded_tokens\n    __typename\n  }\n  validator(where: {validator_info: {operator_address: {_eq: $address}}}) {\n    validatorDescriptions: validator_descriptions(\n      order_by: {height: desc}\n      limit: 1\n    ) {\n      details\n      website\n      __typename\n    }\n    validatorStatuses: validator_statuses(order_by: {height: desc}, limit: 1) {\n      status\n      jailed\n      height\n      __typename\n    }\n    validatorSigningInfos: validator_signing_infos(\n      order_by: {height: desc}\n      limit: 1\n    ) {\n      missedBlocksCounter: missed_blocks_counter\n      tombstoned\n      __typename\n    }\n    validatorInfo: validator_info {\n      operatorAddress: operator_address\n      selfDelegateAddress: self_delegate_address\n      maxRate: max_rate\n      __typename\n    }\n    validatorCommissions: validator_commissions(order_by: {height: desc}, limit: 1) {\n      commission\n      __typename\n    }\n    validatorVotingPowers: validator_voting_powers(\n      offset: 0\n      limit: 1\n      order_by: {height: desc}\n    ) {\n      height\n      votingPower: voting_power\n      __typename\n    }\n    __typename\n  }\n  slashingParams: slashing_params(order_by: {height: desc}, limit: 1) {\n    params\n    __typename\n  }\n}\n"}';

      $fields_string = json_encode($fields);

      $headers = array(
          'Content-Type: application/json',
          'Accept: application/json'
      );

      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_URL, $apiurl);
      curl_setopt($curl, CURLOPT_POST, TRUE);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($curl, CURLOPT_TIMEOUT, 1);

      $data = curl_exec($curl);

      curl_close($curl);

   $decodedData = json_decode($data);

   $array = json_decode($data, true);
   $stakingpool = $array['data']['stakingPool']['0'];
   $validator = $array['data']['validator']['0']['validatorStatuses']['0'];
   $validatorsigninginfos = $array['data']['validator']['0']['validatorSigningInfos']['0'];

   $view = $_GET['view'];

   if($validator['jailed']){
   	$jailed = 1;
   }else{
   	$jailed = 0;
   }

   $monitoringarray = array("poolheight"=>$stakingpool['height'],"validatorheight"=>$validator['height'],"missedblockcount"=>$validatorsigninginfos['missedBlocksCounter'],"validatorjailed"=>$jailed);

   if(!$view){
      header('Content-type: application/json');
      echo json_encode($monitoringarray);
   }

   if($_GET['view'] == 'jailed'){
      echo $jailed;
   }

   if($_GET['view'] == 'poolheight'){
      echo $stakingpool['height'];
   }

   if($_GET['view'] == 'validatorheight'){
      echo $validator['height'];
   }

   if($_GET['view'] == 'missedblockcount'){
      echo $validatorsigninginfos['missedBlocksCounter'];
   }
