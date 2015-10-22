function FindProxyForURL(url, host)
{

//Check for shortname

if (isPlainHostName(host)) {

return "DIRECT";}

//Check for internal domains

if (

dnsDomainIs(host, ".cummins.com") ||

(host == "cummins.com") ||

dnsDomainIs(host, ".cumminspower.com") ||

(host == "cumminspower.com") ||

dnsDomainIs(host, ".onan.com") ||

(host == "onan.com") ||

dnsDomainIs(host, ".cumminsonan.com") ||

(host == "cumminsonan.com") ||

dnsDomainIs(host, ".fleetguard.com") ||

(host == "fleetguard.com") ||

dnsDomainIs(host, ".cumminsfiltration.com") ||

dnsDomainIs(host, ".cumminsturbotechnologies.com") || 

dnsDomainIs(host, ".cmi-inlab.com") || 

dnsDomainIs(host, ".lync.com") || 

dnsDomainIs(host, ".holset.com") ||

dnsDomainIs(host, ".lubricon.com") ||

dnsDomainIs(host, ".cadecsystems.com") ||

dnsDomainIs(host, ".webtrack.mascotsystems.com") ||

dnsDomainIs(host, ".netglearning.com") ||

dnsDomainIs(host, ".aprimo.net") ||

dnsDomainIs(host, "cnhuni2ks0020.cnh.com") ||

dnsDomainIs(host, "impact.daftrucks.com") ||

dnsDomainIs(host, ".yanmar.com") ||

dnsDomainIs(host, ".cmigroups.com") ||

dnsDomainIs(host, ".cummins.eaglegl.com") ||

dnsDomainIs(host, ".cummins.eaglegl.net") ||

dnsDomainIs(host, ".nfuse.cbs-companies.com") ||

dnsDomainIs(host, ".lhpsystems.com") ||

dnsDomainIs(host, ".crmondemand.com") ||

dnsDomainIs(host, ".contactondemand.com") ||

dnsDomainIs(host, "portal.ronin.com") ||

dnsDomainIs(host, ".cumminsengines.com") ||

dnsDomainIs(host, "cumminsengines.com") ||

dnsDomainIs(host, "cummins-distributors.com") ||

dnsDomainIs(host, "eportal.paccar.com") ||

dnsDomainIs(host, ".seagil.com") ||

dnsDomainIs(host, ".adphc.com")){

return "DIRECT";

}

//Check for Hosts

if (

shExpMatch(host, "*owana.cnh.com") ||

shExpMatch(host, "*epdm.cnh.com") ||

shExpMatch(host, "*evr.cnh.com") ||

shExpMatch(host, "*cmp.cnh.com") ||

shExpMatch(host, "hostedgateway2.pwpc.adp.com") ||

shExpMatch(host, "txgateway.myxt.net") ||

shExpMatch(host, "app.bluetie.com") ||

shExpMatch(host, "e2epfn.pfn.vwg") ||

shExpMatch(host, "kvspfv1.pfn.vwg") ||

shExpMatch(host, "*attpoc1.local") ||

shExpMatch(host, "kvspfv2.pfn.vwg")){

return "DIRECT";

}


//Check for URL

//if (

//shExpMatch(url, "http://www.xvideos.com/") ||

//shExpMatch(url, "http:*") ||

//shExpMatch(url, "https:*")){

//return "DIRECT";

//}

//Check for IP addresses 

if (

shExpMatch(host, "10.*")||

shExpMatch(host, "143.222.*")||

shExpMatch(host, "146.47.*")||

shExpMatch(host, "146.91.*")||

shExpMatch(host, "160.95.*")||

shExpMatch(host, "172.16.*")||

shExpMatch(host, "172.17.*")||

shExpMatch(host, "172.18.*")||

shExpMatch(host, "172.19.*")||

shExpMatch(host, "172.20.*")||

shExpMatch(host, "172.21.*")||

shExpMatch(host, "172.22.*")||

shExpMatch(host, "172.23.*")||

shExpMatch(host, "172.24.*")||

shExpMatch(host, "172.25.*")||

shExpMatch(host, "172.26.*")||

shExpMatch(host, "172.27.*")||

shExpMatch(host, "172.28.*")||

shExpMatch(host, "172.29.*")||

shExpMatch(host, "172.30.*")||

shExpMatch(host, "172.31.*")||

shExpMatch(host, "192.158.*")||

shExpMatch(host, "192.168.*")||

shExpMatch(host, "208.243.98.*")||

shExpMatch(host, "216.249.99.70")|| 

shExpMatch(host, "71.40.12.171")||

shExpMatch(host, "70.228.180.200")||

shExpMatch(host, "12.196.170.20")||

shExpMatch(host, "216.46.253.40")|| 

shExpMatch(host, "216.46.253.8")|| 

shExpMatch(host, "216.46.253.202")|| 

shExpMatch(host, "216.46.253.203")|| 

shExpMatch(host, "216.46.253.70")||

shExpMatch(host, "182.169.246.30:")||

shExpMatch(host, "127.*")){

return "DIRECT";

}

//Check for Business Critical URLs 
//{
//example  if (shExpMatch(host,  "*.cisco.com"))
//example  return "PROXY fw1.cummins.com:80; fw1-ftdc.cummins.com:80";
//}
//After all else fails
return "PROXY wpad.cummins.com:80"; 
}

