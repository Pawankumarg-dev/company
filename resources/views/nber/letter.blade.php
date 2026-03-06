<style>
  table, th, td{
        border: 1px solid #ccc;
        border-collapse: collapse;
        padding:8px;
    }
</style>
<p>To<p>
<p>{{$ec->address}}<p>
<p>To download the examination centre wise list of candidates, attendance sheet, format 
for reporting malpractice, Guidelines for conducting examination, format for CLO 
report etc. from RCI NBER website -reg.<p>
<p>Madam/ Sir,<p>
<p>Enclosed, please find the following details for downloading the examination centre 
wise list of candidates, attendance sheet and other relevant documents. <p>

<table>
  <tr>
    <th>Examination Centre Code</th>
    <th>Name of the KV</th> 
    <th>Website Address</th>
    <th>Login ID </th>
    <th>Password</th>
  </tr>
  <tr>
    <td>{{$ec->code}}</td>
    <td>{{$ec->address}}</td>
    <td>https://rcinber.org.in/login#examcenter</td>
    <td>{{$ec->email1}}</td>
    <td>{{$ec->password}}</td>
  </tr>
</table> 

<p>It is requested that the requisite information to be downloaded by using above said login id and password.<p>

<p>Thanking you.<p>


