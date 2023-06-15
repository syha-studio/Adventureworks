<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %>
<%@ taglib uri="http://www.tonbeller.com/jpivot" prefix="jp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core" %>

<jp:mondrianQuery id="query01" jdbcDriver="com.mysql.jdbc.Driver"
jdbcUrl="jdbc:mysql://localhost/adventureworks_dw?user=root&password=" catalogUri="/WEB-INF/queries/dwoadw1.xml">
  select {[Measures].[Total Order Quantity],[Measures].[Total Incomes]} ON COLUMNS,
  {([Address], [Time], [Product], [Customer], [Shipping Method])} ON ROWS
  from [Sales]
</jp:mondrianQuery>

<c:set var="title01" scope="session">Query DWO Adventureworks (Sales Schema) using Mondrian OLAP</c:set>
