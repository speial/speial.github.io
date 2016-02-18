(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-73963011-1', 'auto');
ga('send', 'pageview');

speialAnalytics={};

speialAnalytics.elementIsAlink=function(element)
{
 if (typeof element.tagName == 'undefined') return false;
 if (element.tagName.toLowerCase() != 'a')  return false;
 if (!element.href) return false;
 return true;
}

speialAnalytics.onClick=function(event)
{
 var element = event.srcElement || event.target;
 while(!speialAnalytics.elementIsAlink(element))
 {
  element = element.parentNode;
  if (!element) return;
 }
 var link = element.href;
 if(link.indexOf(location.host) > -1) return;
 var toHost  =element.hostname; 
 var fromPath=location.pathname;
 ga('send', 'event', 'link_click', toHost, fromPath);
}

document.body.addEventListener("click",speialAnalytics.onClick,false);
