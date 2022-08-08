# CUDOSStatusAPI
Get data about a validator on the cudos blockchain

# Install
It's a pretty basic PHP page. Just run on a machine with PHP, add it to your httpdocs, sure php_curl is enabled. Good to go.

# Usage
For all information:  https://hostaddress/endpoint.php?address={validator_address}

Validator Jailed: https://hostaddress/endpoint.php?address={validator_address}&view=jailed

Current Pool/Network Block Height: https://hostaddress/endpoint.php?address={validator_address}&view=poolheight

Current Validator Block Height: https://hostaddress/endpoint.php?address={validator_address}&view=validatorheight

Current Missed Block Count: https://hostaddress/endpoint.php?address={validator_address}&view=missedblockcount

