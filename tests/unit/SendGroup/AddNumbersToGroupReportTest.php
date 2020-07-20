<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Test\Unit\SendGroup;

use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use Nessworthy\TextMarketer\SendGroup\AddNumbersToGroupReport;
use PHPUnit\Framework\TestCase;

class AddNumbersToGroupReportTest extends TestCase
{

    public function testGetAddedNumbers(): void
    {
        $addedNumbers = $this->createMock(PhoneNumberCollection::class);

        $addedNumbers
            ->method('asArray')
            ->willReturn(['0000000001', '0000000002']);

        $stoppedNumbers = $this->createMock(PhoneNumberCollection::class);
        $duplicateNumbers = $this->createMock(PhoneNumberCollection::class);

        $report = new AddNumbersToGroupReport($addedNumbers, $stoppedNumbers, $duplicateNumbers);

        $this->assertEquals(['0000000001', '0000000002'], $report->getAddedNumbers());
    }

    public function testGetTotalAddedNumbers(): void
    {
        $addedNumbers = $this->createMock(PhoneNumberCollection::class);

        $addedNumbers
            ->method('getTotal')
            ->willReturn(5);

        $stoppedNumbers = $this->createMock(PhoneNumberCollection::class);
        $duplicateNumbers = $this->createMock(PhoneNumberCollection::class);

        $report = new AddNumbersToGroupReport($addedNumbers, $stoppedNumbers, $duplicateNumbers);

        $this->assertEquals(5, $report->getTotalAddedNumbers());
    }

    public function testGetStoppedNumbers(): void
    {
        $stoppedNumbers = $this->createMock(PhoneNumberCollection::class);

        $stoppedNumbers
            ->method('asArray')
            ->willReturn(['0000000003', '0000000004']);

        $addedNumbers = $this->createMock(PhoneNumberCollection::class);
        $duplicateNumbers = $this->createMock(PhoneNumberCollection::class);

        $report = new AddNumbersToGroupReport($addedNumbers, $stoppedNumbers, $duplicateNumbers);

        $this->assertEquals(['0000000003', '0000000004'], $report->getStoppedNumbers());
    }

    public function testGetTotalStoppedNumbers(): void
    {
        $stoppedNumbers = $this->createMock(PhoneNumberCollection::class);

        $stoppedNumbers
            ->method('getTotal')
            ->willReturn(10);

        $addedNumbers = $this->createMock(PhoneNumberCollection::class);
        $duplicateNumbers = $this->createMock(PhoneNumberCollection::class);

        $report = new AddNumbersToGroupReport($addedNumbers, $stoppedNumbers, $duplicateNumbers);

        $this->assertEquals(10, $report->getTotalStoppedNumbers());
    }

    public function testGetDuplicateNumbers(): void
    {
        $duplicateNumbers = $this->createMock(PhoneNumberCollection::class);

        $duplicateNumbers
            ->method('asArray')
            ->willReturn(['0000000004', '0000000005']);

        $addedNumbers = $this->createMock(PhoneNumberCollection::class);
        $stoppedNumbers = $this->createMock(PhoneNumberCollection::class);

        $report = new AddNumbersToGroupReport($addedNumbers, $stoppedNumbers, $duplicateNumbers);

        $this->assertEquals(['0000000004', '0000000005'], $report->getDuplicateNumbers());
    }

    public function testGetTotalDuplicateNumbers(): void
    {
        $duplicateNumbers = $this->createMock(PhoneNumberCollection::class);

        $duplicateNumbers
            ->method('getTotal')
            ->willReturn(15);

        $addedNumbers = $this->createMock(PhoneNumberCollection::class);
        $stoppedNumbers = $this->createMock(PhoneNumberCollection::class);

        $report = new AddNumbersToGroupReport($addedNumbers, $stoppedNumbers, $duplicateNumbers);

        $this->assertEquals(15, $report->getTotalDuplicateNumbers());
    }
}
