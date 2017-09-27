<?
class TRecordset 
{
		var $fields_by_name;	
		var $fields_by_type;
		var $fields_by_flag;
		var $cur=0;
		var $numfields;
		var $numrows;
		var $fieldname;
		var $eof;
		var $found_rows;

		function Close() 
		{
			if ($this->cur) @mysql_free_result($this->cur);
		}	
		
		function MoveFirst()
		{
			$this->MoveRow(0);
		}
		
		function MoveRow($index)
		{
			if(!mysql_data_seek($this->cur,$index)) 
				$this->eof = true;
			else
			{										
				$this->numrows = @mysql_num_rows($this->cur);
				$this->eof = false;
				$this->MoveNext();
			}
		}
	
		function MoveNext() 
		{ 
			$data=@mysql_fetch_row($this->cur);
			if (isset($data[0])) 
			{
				for ($i=0;$i<mysql_num_fields($this->cur);$i++) 
				{	
					$n_m=strtoupper(mysql_field_name($this->cur, $i));
					$this->fields_by_name[$n_m]=$data[$i];
					$this->fields_by_type[$n_m]=mysql_field_type($this->cur, $i);
					$this->fields_by_flag[$n_m]=explode(" ",mysql_field_flags($this->cur, $i));
				}
				$this->numrows = mysql_num_rows($this->cur);
				$this->eof = false;
			} 
			else 
			{
				if ($this->cur) $this->numrows=@mysql_num_rows($this->cur);
				$this->eof = true;
			}
		}
		
		function ReturnId()
		{
			return @mysql_insert_id();	
		}		
		
		function Field($id) 
		{
			return $this->fields_by_name[strtoupper($id)];
		}
		
		function Format_Date($id){
			$tmp = strtok($this->Field($id)," ");
			$tmp = explode("-",$tmp);
			return $tmp[2]."/".$tmp[1]."/".$tmp[0];
		}
		
		function FieldType($id) 
		{
			return $this->fields_by_type[strtoupper($id)];
		}
		
		function FieldFlag($id) 
		{
			return $this->fields_by_flag[strtoupper($id)];
		}
		
		function AffectedRow()
		{
			return mysql_affected_rows();
		}				
				
		function Display() 
		{					
			echo "<table border=1 cellspacing=0 cellpadding=0>\n<tr>";
			for ($i=0; $i<$this->numfields; $i++) echo "<td nowrap class='textonegro2'>".$this->fieldname[$i]."</td>";
			echo "</tr>\n";
	
			for(;!$this->eof;$this->MoveNext()) 
			{
				echo "<tr>";
				for ($i=0; $i< $this->numfields; $i++) echo "<td nowrap class='textonegro2'>&nbsp;".$this->field($this->fieldname[$i])."</td>";
				echo "</tr>\n";				
			}
			echo "</table>\n";		
			$this->MoveFirst();
		}		
}
	
class TConnection 
{
		var $conn=0;
		var $rs;
		var $qry;
		
		function Connect($host, $user, $password, $db="") 
		{
			$this->conn = @mysql_connect($host, $user, $password); 
			if ($this->conn && $db) mysql_select_db($db, $this->conn);
			return $this;
		}
		
		function Disconnect() 
		{
			if ($this->conn) mysql_close($this->conn);
		}	
		
		function Execute($sqlstat) 
		{	
			$this->qry = $sqlstat;	
			$this->rs = new TRecordset;
			if ($this->conn) $this->rs->cur = mysql_query($sqlstat, $this->conn);
			if ($this->rs->cur) 
			{
				$this->rs->numfields = @mysql_num_fields($this->rs->cur);
				for ($i=0; $i < $this->rs->numfields; $this->rs->fieldname[$i]=mysql_field_name($this->rs->cur, $i),$i++);
				$this->rs->MoveNext();
			}
			
			if(strpos($sqlstat,'SQL_CALC_FOUND_ROWS')){ 
				$tmpRs = mysql_query("SELECT FOUND_ROWS() AS TOT;", $this->conn);
				$tmpRs = mysql_fetch_array($tmpRs);
				$this->rs->found_rows = $tmpRs[TOT];
			}
			
			return ($this->rs->cur)?$this->rs:false;
		}
		
		function start_transaction()
		{
			return $this->Execute("START TRANSACTION");			
		}
		
		function commit()
		{
			return $this->Execute("COMMIT");
		}
		
		function rollback()
		{
			return $this->Execute("ROLLBACK");
		}
		
		function errmsg()
		{
			return @mysql_error($this->conn);
		}
		
		function errnro()
		{
			return @mysql_errno($this->conn);
		}

		function ReturnId()
		{
			return @mysql_insert_id($this->conn);	
		}		
		
		function AffectedRow()
		{
			return mysql_affected_rows($this->conn);
		}
		
		function info()
		{
			return @mysql_info();
		}
		
		function errHTML(){
			return "<br><b><font color=\"#FF0000\" >Error ".$this->errnro().":</font> ".$this->errmsg()."</b><br><em><font size=\"-1\">Qry: ".$this->qry."</font></em><br>";
		}
}

?>