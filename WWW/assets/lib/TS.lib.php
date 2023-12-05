<?
class TimeSlot {
    private $startTime;
    private $endTime;

    public function __construct($startTime, $endTime) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    // Getters and setters for start and end times
    public function getStartTime() {
        return $this->startTime;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    public function calculateDurationInMinutes() {
        $start = strtotime($this->startTime);
        $end = strtotime($this->endTime);

        // Calculate the difference between end and start times in seconds
        $durationInSeconds = $end - $start;

        // Convert seconds to minutes
        $durationInMinutes = round($durationInSeconds / 60);

        return $durationInMinutes;
    }

}
?>