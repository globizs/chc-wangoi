<?php

namespace frontend\models;

use Yii;
use DateTime;
use common\models\User;

/**
 * This is the model class for table "opd".
 *
 * @property int $id
 * @property int $opd_registration_no
 * @property string|null $abha_id
 * @property string $patient_name
 * @property string $care_taker_name
 * @property int $age
 * @property string|null $gender
 * @property int|null $religion_id
 * @property string $address
 * @property string $diagnosis
 * @property int $fee_amount
 * @property string $opd_date
 * @property int $opd_session_id
 * @property int $department_id
 * @property int $created_by_user_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string $is_active
 *
 * @property User $createdByUser
 * @property Department $department
 * @property OpdSession $opdSession
 * @property Religion $religion
 */
class Opd extends \yii\db\ActiveRecord
{
    public $age_formatted;      // just to show year month etc.
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_registration_no', 'serial_no', 'patient_name', 'care_taker_name', 'address', 'fee_amount', 'opd_date', 'opd_session_id', 'department_id', 'gender', 'date_of_birth'], 'required'],
            [['opd_registration_no', 'religion_id', 'fee_amount', 'opd_session_id', 'department_id'], 'integer'],
            [['gender', 'address'], 'string'],
            [['date_of_birth'], 'string', 'min' => 10, 'max' => 11],
            [['opd_date'], 'string', 'min' => 10, 'max' => 20],
            [['contact_no'], 'match', 'pattern' => '/^[5-9]\d{9}$/', 'message' => 'Please enter a valid 10-digit mobile number'],
            [['abha_id'], 'match', 'pattern' => '/^\d{14}$/', 'message' => 'ABHA ID must be a 14-digit number'],
            [['aadhaar_no'], 'match', 'pattern' => '/^\d{12}$/', 'message' => 'AADHAAR No. must be a 12-digit number'],
            [['patient_name', 'care_taker_name'], 'string', 'max' => 255],
            [['is_active'], 'string', 'max' => 1],
            // [['opd_registration_no'], 'unique'],
            [['religion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Religion::class, 'targetAttribute' => ['religion_id' => 'id']],
            [['opd_session_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpdSession::class, 'targetAttribute' => ['opd_session_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'opd_registration_no' => 'O.P.D. Regn. No.',
            'serial_no' => 'Sl. No.',
            'abha_id' => 'ABHA ID',
            'aadhaar_no' => 'AADHAAR No.',
            'patient_name' => 'Name of Patient',
            'contact_no' => 'Contact No.',
            'care_taker_name' => 'Name of Husband/Guardian',
            'date_of_birth' => 'Date of Birth',
            'age' => 'Age',     // this now stores no. of days
            'age_formatted' => 'Age',
            'gender' => 'Sex',
            'religion_id' => 'Religion',
            'address' => 'Address',
            'diagnosis' => 'Diagnosis/Prov. Diagnosis',
            'fee_amount' => 'Fee (Rs.)',
            'opd_date' => 'OPD date',
            'opd_session_id' => 'OPD session',
            'department_id' => 'Department',
            'created_by_user_id' => 'Entry by',
        ];
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[OpdSession]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpdSession()
    {
        return $this->hasOne(OpdSession::class, ['id' => 'opd_session_id']);
    }

    /**
     * Gets query for [[Religion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReligion()
    {
        return $this->hasOne(Religion::class, ['id' => 'religion_id']);
    }

    public function getCreateByUserId()
    {
        return $this->hasOne(User::class, ['id' => 'created_by_user_id']);
    }

    // to find no. of days between 2 dates
    public function calculateDaysBetweenDates($date1, $date2) {
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $interval = $datetime1->diff($datetime2);

        return $interval->days;
    }    

    // to convert days to age format
    public function convertDaysToAge($days) {
        if ($days < 60) {
            // Less than 2 months
            return "$days days";
        }
    
        $years = floor($days / 365);
        $remainingDays = $days % 365;
    
        if ($years < 6) {
            // Less than 6 years, show in months and days
            $months = floor($remainingDays / 30);
            $remainingDays %= 30;
            $totalMonths = ($years * 12) + $months;
            return "$totalMonths months, $remainingDays days";
        }
    
        // 6 years or more, show in years, months, and days
        $months = floor($remainingDays / 30);
        $remainingDays %= 30;

        return "$years years, $months months, $remainingDays days";
    }

    // to calculate days from age format
    public function calculateDaysFromAge($years, $months = 0, $days = 0) {
        $totalDays = ($years * 365) + ($months * 30) + $days;

        return $totalDays;
    }

    // generate reg. no. (It starts at 1 every day)
    public function generateRegNo() {
        // Convert $opd_date to DateTime object if it is not already
        $opdDate = new DateTime($this->opd_date);

        // Extract just the date part of opd_date (ignoring the time)
        $startOfDay = $opdDate->format('Y-m-d') . ' 00:00:00';
        $endOfDay = $opdDate->format('Y-m-d') . ' 23:59:59';

        // Query to find the maximum opd_registration_no for today
        $maxRegistrationNo = Opd::find()
            ->select(['MAX(opd_registration_no)'])
            ->where(['>=', 'opd_date', $startOfDay])
            ->andWhere(['<=', 'opd_date', $endOfDay])
            ->andWhere(['is_active' => '1'])
            ->scalar();

        // Calculate the next opd_registration_no (start from 1 if none found)
        $this->opd_registration_no = $maxRegistrationNo ? $maxRegistrationNo + 1 : 1;
    }

    // generate serial no. (It starts at 1 on 1st April every year)
    public function generateSerial() {
        // Convert $opd_date to DateTime object for manipulation
        $opdDate = new DateTime($this->opd_date);

        // Extract the year from the provided opd_date
        $year = $opdDate->format('Y');

        // Determine the start and end dates of the fiscal year
        $fiscalYearStart = new DateTime("{$year}-04-01");
        $nextFiscalYearStart = new DateTime("{$year}-04-01 +1 year");

        // If $opd_date is before April 1st, adjust to the previous fiscal year
        if ($opdDate < $fiscalYearStart) {
            $fiscalYearStart->modify('-1 year');
            $nextFiscalYearStart->modify('-1 year');
        }

        // Fetch the maximum serial_no within the current fiscal year
        $maxSerialNo = Opd::find()
        ->select(['MAX(serial_no)'])
        ->where(['>=', 'DATE(opd_date)', $fiscalYearStart->format('Y-m-d')])
        ->andWhere(['<', 'DATE(opd_date)', $nextFiscalYearStart->format('Y-m-d')])
        ->andWhere(['is_active' => '1'])
        ->scalar();    

        // Calculate the next serial number
        $this->serial_no = $maxSerialNo ? $maxSerialNo + 1 : 1;
    }
}
