<?php

class ZSaveRelationBehavior extends CActiveRecordBehavior
{
	public $relatedRecords = array();
	
	public function setRelationRecords($relation, $newRecords, $oldRecords = array())
	{
		$activeRelation = $this->owner->getActiveRelation($relation);
		
		$relationRecords = array();
		
		foreach ($newRecords as $key=>$record)
		{
			$currentRecord = null;
			
			if (!is_object($record))
			{
				$currentRecord = new $activeRelation->className;
				
				$currentRecord->attributes = $record;
			}
			else
			{
				$currentRecord = $record;
			}
			
			$relationRecords[$key] = $currentRecord;
		}
		
		$this->owner->{$relation} = $relationRecords;
		
		$this->relatedRecords[$relation] = array('new'=>$relationRecords, 'old'=>$oldRecords);
	}
	
	/**
	 * Saves model related records for specified relation.
	 * @param string $relation model relation name
	 * @return boolean whether update succeded
	 */
	
	public function saveRelationRecords($relation)
	{
		$activeRelation = $this->owner->getActiveRelation($relation);
		
		$correct = true;
		
		foreach ($this->relatedRecords[$relation]['old'] as $oldRecord)
		{
			if (!$oldRecord->delete())
			{
				$correct = false;
			}
		}
		
		foreach ($this->relatedRecords[$relation]['new'] as $newRecord)
		{
			$newRecord->{$activeRelation->foreignKey} = $this->owner->id;

			if (!$newRecord->save())
			{
				$correct = false;
			}
		}

		return $correct;
	}
}

?>