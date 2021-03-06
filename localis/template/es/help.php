<?
$GLOBALS['textehelp'] =<<<_END_
<h2>Ayuda</h2>
Localis permite visualizar el resultado de una b�squeda en varias bases de datos. Adem�s, Localis es una herramienta cartogr�fica contributiva en l�nea. Permite al usuario agregar y calificar puntos en un mapa, a los que pueden acceder a su vez otros usuarios. el conjunto de esas bases de datos georeferenciadas y cartogr�ficas constituye "la fuente de informaci�n". 
<br><br>
Esta herramienta est� compuesta de varios m�dulos para los usuarios : <br><br>
<b>El modulo "formulario de b�squeda" : </b><br>
<ul><li>El campo "B�squeda" : es nada menos que un motor de b�squeda.</li>
<li>El men� desplegable : se puede acceder a los objetos presentes en "la fuente de informaci�n" seg�n las categor�as precalificadas listadas en los men�s desplegables.<br>
Es posible cruzar los elementos seleccionados, a partir de las diferentes opciones de ingreso de datos, para obtener respuestas m�s precisas.</li></ul>

<ul><b>Nota :</b><br>
Para pasar a la siguiente etapa, hay que seleccionar el modo de visualizaci�n de resultados : como un "mapa" en modo imagen, o como una "lista" en modo texto. Esta selecci�n validar� el conjunto de opciones elegidas por el usuario y someter� la petici�n al servidor.</ul>
<br>

<b>El m�dulo "modo lista (texto)" :</b><br>
El conjunto de respuestas a la petici�n se presenta como una lista. Un enlace lleva hacia una ficha detallada para cada respuesta. 
<br><br><br>

<b>El m�dulo "modo mapa (imagen)" :</b><br>
La lista se acompa�a con la localizaci�n de los puntos en un mapa.<br>
Se puede acceder a las herramientas propias a este modo de visualizaci�n, �stas son :
<ul>
<li>El mapa de navegaci�n : es una representaci�n en escala fija de la totalidad de la zona geogr�fica en cuesti�n y permite al usuario posicionar la representaci�n visible en la imagen principal.</li>

<li>El bot�n "recentrar" : muestra la totalidad del mapa de la regi�n. Puede ser pr�ctico volver a la vista general luego de haber navegado en un mapa sin perder la petici�n inicial.</li>

<li>El men� desplegable "400x400" : Propone diferentes resoluciones gr�ficas para la visualizaci�n del mapa principal (200x200, 400x400, 600x600, 800x800). Para cambiar la resoluci�n y refrescar la p�gina, cliquee sobre el bot�n de validaci�n '>>'. Al cambiar de resoluci�n, se mantienen tanto la b�squeda en curso asi como el encuadre elegido.</li>

<li>Las opciones de "clic" del rat�n sobre el mapa : Las herramientas se seleccionan cliqueando en su "bot�n radio" correspondiente.<br>
Las opciones accesibles son : <ul>
<li>la opci�n <b>"Plantar una Bandera"</b> (la bandera dorada): al seleccionar esta opci�n, el usuario puede "plantar" la bandera en alg�n lugar del mapa. Luego, puede ingresar informaci�n para ese punto. Una vez el punto calificado, �ste se encontrar� accesible a la b�squeda para los otros usuarios.</li>
<li>la opci�n <b>"Lupa"</b>, sus iconos de zoom tienen los simbolos - (para alejarse) y + (para acercarse). Tanto la escala como el indicador de distancia bajo el mapa son actualizados cada vez que se usa esta opci�n.</li>
<li>la opci�n <b>"Reencuadrar"</b> situada entre las lupas (�cono en forma de cruz) permite, al seleccionarse, desplazarse sobre el mapa. El punto seleccionado (con un clic) sobre el mapa estar� en el centro del mapa de la p�gina siguiente. El uso de esta opci�n es el mismo tanto sobre el mapa principal como sobre el mapa de navegaci�n.</li>
<br></ul>

<li>Los elementos llamados "calcos" ("layers") aparte de filtrar la b�squeda, forman parte de la respuesta cartogr�fica y mejoran la lisibilidad del mapa. Estas pueden seleccionarse independientemente (nombre de las ciudades, contorno de las regiones...).<br>
Para poder ver el calco deseado en forma sencilla y para una misma petici�n, el usuario cuenta con el bot�n "Recalcular".</li>
</ul>
<br>

<b>Nota sobre las URL de Localis :</b><br>
Cuando se consigi� la visualizaci�n de las informaciones y el nivel de visibilidad deseado (presencia de �ste o aquel calco, dimensi�n de la imagen), se puede conservar la direcci�n de esta vista / p�gina con todas sus informaciones, o sea, la petici�n a las bases (como una url) que permite construir la vista.<br><br>
Esta particularidad tiene dos ventajas principales : <ul>
<li>Permite capitalizar sus "favoritos" (bookmarks), y el tiempo pasado en construir el documento personalizado (al guardar la petici�n en los favoritos).</li>
<li>Permite transmitir la direcci�n de la p�gina a un interlocutor, para que �ste no pierda tiempo reconstruyendo la vista, y estando seguro de trabajar sobre el mismo documento, al utilizar la misma petici�n para consultar las mismas bases.</li>
</ul>
<br>
Tenga en cuenta que se trata de una herramienta en desarrollo, puede encontrarse con imperfecciones o problemas de funcionamiento.<br>
Si se encuentra con alguna, por favor comuniqueselo a <a href=mailto:mose@makina-corpus.org>mose</a>.
_END_;
?>
