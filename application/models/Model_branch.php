<?php
class Model_branch extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getBranch()
	{
	    if (in_array('viewBranchJakarta', $this->permission))
	    {
		    $sql = "SELECT * FROM `branch` WHERE id = 13";
		    $query = $this->db->query($sql);
		    return $query->result_array();
	    }
	    if (in_array('viewBranchMedan', $this->permission))
	    {
		    $sql = "SELECT * FROM `branch` WHERE id = 14";
		    $query = $this->db->query($sql);
		    return $query->result_array();
	    }
	    if (in_array('viewBranchSurabaya', $this->permission))
	    {
		    $sql = "SELECT * FROM `branch` WHERE id = 15";
		    $query = $this->db->query($sql);
		    return $query->result_array();
	    }
	}

	public function getBranchbyID($id)
	{
		$sql = "SELECT * FROM `branch` WHERE `id` = ?";
		$query = $this->db->query($sql, $id);
		return $query->row_array();
	}

	/* get the Jakarta data */
	public function getJakartaData()
	{
		$sql = "SELECT * FROM `products` WHERE `branch_id`= 13 ORDER BY id DESC;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getJakartaDatabyID($id)
	{
			$sql = "SELECT * FROM `products` WHERE `branch_id`= 13 AND `id` = ?";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
	}



	/* get the Medan data */
	public function getMedanData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `products` WHERE `branch_id`= 14 AND `id` = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `products` WHERE `branch_id`= 14 ORDER BY id DESC;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMedanDatabyID($id)
	{
			$sql = "SELECT * FROM `products` WHERE `branch_id`= 14 AND `id` = ?";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
	}

	/* get the Surabaya data */
	public function getSurabayaData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM `products` WHERE `branch_id`= 15 AND `id` = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `products` WHERE `branch_id`= 15 ORDER BY id DESC;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getSurabayaDatabyID($id)
	{
			$sql = "SELECT * FROM `products` WHERE `branch_id`= 15 AND `id` = ?";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
	}
}

?>