 function setTagCloudStyle(){ 
  var colors = new Array("color0","color1","color2","color3","color4","color5","color6"); //定义不同颜色样式,这个大家可以自己增加数组中的值以增加更丰富的效果,次数组提供7种颜色, 
  //但是要注意这里增加了样式要注意不要忘记了增加上边css中的样式,否则没有效果. 
  var sizes = new Array("size0","size1","size2","size3","size4","size5","size6"); //定义不同字体样式,这个大家可以自己增加数组中的值以增加更丰富的效果,次数组提供7种字体大小, 
  //但是要注意这里增加了样式要注意不要忘记了增加上边css中的样式,否则没有效果. 
  var weights = new Array("weight0","weight1","weight2","weight3","weight4","weight5","weight6"); //定义不同字体样式,这个大家可以自己增加数组中的值以增加更丰富的效果,次数组提供7种字体大小, 
  //但是要注意这里增加了样式要注意不要忘记了增加上边css中的样式,否则没有效果. 
  //其实这里大家还可以自己增加比如字体样式,宋体、楷体、......等,可以自己修改 
  var colorsLen = colors.length;//获取颜色样式个数 
  var sizesLen = sizes.length;//获取字体大小样式个数 
  var weightsLen = weights.length;//获取字体粗细样式个数 
   
  var tagCloud = document.getElementById("tagCloud"); 
  var tagLinks = tagCloud.getElementsByTagName("a"); 
  var tagLinksLen = tagLinks.length; 
   
  for(i = 0 ; i < tagLinksLen ; i++){ 
   tagLinks[i].className = colors[Math.floor(colorsLen*Math.random())] + " " + sizes[Math.floor(sizesLen*Math.random())]+ " " + weights[Math.floor(weightsLen*Math.random())]; 
   //随机设置每个<a>标签的样式,以实现不同效果. 
  } 
 } 
  
 if(document.addEventListener){ 
  window.addEventListener('load',setTagCloudStyle,false); 
 }else{ 
  window.attachEvent('onload',setTagCloudStyle); 
 } 
 //绑定onload事件,在文档载入完毕启动setTagCloudStyle()函数; 
