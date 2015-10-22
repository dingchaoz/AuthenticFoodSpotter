function FindProxyForURL(url, host)
{
  if (shExpMatch(url, "http:*"))
    return "DIRECT";
  if (shExpMatch(url, "https:*"))
    return "DIRECT";
  return "DIRECT";
}