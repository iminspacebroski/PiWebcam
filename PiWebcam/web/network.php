<?php 
	include "header.php";
	// form submitted
	if(count($_REQUEST) > 0) {
		if (array_key_exists("WIFI_MODE",$_REQUEST)) run("set_wifi_mode '".$_REQUEST["WIFI_MODE"]."'");
		if (array_key_exists("AP_PASSPHRASE",$_REQUEST)) run("set_wifi_ap '".$_REQUEST["AP_PASSPHRASE"]."'");
		if (array_key_exists("WIFI_SSID",$_REQUEST)) run("set_wifi_client '".$_REQUEST["WIFI_SSID"]."' '".$_REQUEST["WIFI_PASSPHRASE"]."'");
		if (array_key_exists("NETWORK_IP",$_REQUEST)) run("set_network_ip '".$_REQUEST["NETWORK_IP"]."' '".$_REQUEST["NETWORK_GW"]."' '".$_REQUEST["NETWORK_DNS"]."'");
		if (array_key_exists("REMOTE_ACCESS",$_REQUEST)) run("set_remote_access '".$_REQUEST["REMOTE_ACCESS"]."'");
		run("configure_network");
		load_config();
		array_push($message["success"],"Configuration applied successfully");
	}
	include "messages.php";
	generate_modal("confirm_modal","The device may become unresponsive on the network for a short timeframe while applying the new configuration.<br>If changing WiFi Mode (\"Access Point\"/\"WiFi Client\"), you need to reconnect to the different network.","button","form");
?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-<?php print $env["MY_WEB_PANEL_STYLE"] ?>">
                        <div class="panel-heading">
                           <i class="fa fa-video-camera fa-fw"></i> Network & WiFi
                        </div>
                        <div class="panel-body">
							<form id="form" method="POST" role="form">
								<div class="row">
									<div class="col-lg-6">
										<div class="panel panel-default">
											<div class="panel-body">
												<h3>WiFi Settings</h3>
												<label>WiFI Mode</label>
												<div class="form-group">
													<div class="radio">
														<label>
															<input name="WIFI_MODE" value="AP" type="radio"<?php if ($config["WIFI_MODE"] === "AP" || $config["WIFI_MODE"] === "") print " checked"?> onclick='$("#ap_panel").removeClass("hidden");$("#client_panel").addClass("hidden"); $("#network_panel :input").prop("disabled",1);'>Access Point
															<p class="help-block">Act as an access point with SSID <i>
															"<?php print $config["NAME"] ?>"</i></p>
														</label>
													</div>
													<div class="radio">
														<label>
															<input name="WIFI_MODE" value="CLIENT" type="radio"<?php if ($config["WIFI_MODE"] === "CLIENT") print " checked"?> onclick='$("#ap_panel").addClass("hidden");$("#client_panel").removeClass("hidden"); $("#network_panel :input").prop("disabled",0);'>WiFi Client
															<p class="help-block">Connect to an existing WiFi network</p>
														</label>
													</div>
												</div>
												<div id="ap_panel" class="<?php if ($config["WIFI_MODE"] === "CLIENT") print " hidden"?>">
												<div class="form-group">
													<label>Access Point Passphrase</label>
													<input name="AP_PASSPHRASE" type="password" class="form-control" value="<?php print $config["AP_PASSPHRASE"]?>">
													<p class="help-block">The passphrase to use when connecting to this access point (minimum 8 characters). Leave it empty for no password</p>
												</div>
												</div>
												<div id="client_panel" class="<?php if ($config["WIFI_MODE"] != "CLIENT") print " hidden"?>">
												<div class="form-group">
													<label>WiFi network</label>
													<input name="WIFI_SSID" class="form-control" value="<?php print $config["WIFI_SSID"]?>">
													<p class="help-block">The name of the wireless network (SSID) to connect to</p>
												</div>
												<div class="form-group">
													<label>Passphrase</label>
													<input name="WIFI_PASSPHRASE" type="password" class="form-control" value="<?php print $config["WIFI_PASSPHRASE"]?>">
													<p class="help-block">The passphrase to use to connect to the network. Leave it empty for open networks</p>
												</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div id="network_panel" class="panel panel-default">
											<div class="panel-body">
												<h3>Network Settings</h3>
												<div class="form-group">
													<label>IP address</label>
													<input name="NETWORK_IP" <?php if ($config["WIFI_MODE"] == "AP") print " disabled"?> class="form-control" value="<?php print $config["NETWORK_IP"]?>">
													<p class="help-block">Set a static IP address for this device. Leave it empty to use DHCP</p>
												</div>
												<div class="form-group">
													<label>Gateway</label>
													<input name="NETWORK_GW" <?php if ($config["WIFI_MODE"] == "AP") print " disabled"?> class="form-control" value="<?php print $config["NETWORK_GW"]?>">
													<p class="help-block">Set the default gateway. Leave it empty for having DHCP setting it</p>
												</div>
												<div class="form-group">
													<label>DNS server</label>
													<input name="NETWORK_DNS" <?php if ($config["WIFI_MODE"] == "AP") print " disabled"?> class="form-control" value="<?php print $config["NETWORK_DNS"]?>">
													<p class="help-block">Set the DNS server to use. Leave it empty for having DHCP setting it</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-default">
											<div class="panel-body">
												<h3>Remote Access</h3>
												<div class="checkbox">
													<label>
														<input type='hidden' value="0" name="REMOTE_ACCESS">
														<input value="1" name="REMOTE_ACCESS" type="checkbox"<?php if ($config["REMOTE_ACCESS"] === "1") print " checked"; ?>>Allow remote Internet access
													<p class="help-block">If checked, the device will be recheable from the Internet at the following URL: <b><a target="_blank" href="http://
													<?php print strtolower($config["NAME"]) ?>.serveo.net">http://<?php print strtolower($config["NAME"]) ?>.serveo.net</a></b><br>
													Please ensure a strong password is set before proceeding.</p>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<button id="button" type="submit" onclick='$("#button").addClass("disabled"); $("#confirm_modal").modal("show");return false;' class="pull-right btn btn-primary">Apply settings</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
<?php 
	include "footer.php" 
?>