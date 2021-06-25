<?php


namespace App\Command;

use App\Entity\Address;
use App\Entity\Sgroup;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CsvImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports a mock CSV file')
            ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io -> title('Attempting to import the feed...');

        $reader = Reader::createFromPath('public/uploads/Data/MOCK_DATA.csv');
        $results = $reader->fetchAssoc();

        foreach ($results as $row){


            $student=(new Student())
                ->setEmail($row['email'])
                ->setFirstname($row['firstname'])
                ->setLastname($row['lastname'])
                ->setPassword($row['password'])
                ->setCreated(new \DateTime())
                ->setUpdated(new \DateTime());

            $this->em->persist($student);

            $sgroup = $this->em->getRepository(Sgroup::class)
                ->findOneBy([
                    'group_name' => $row['group_name']
                ]);

            if (null === $sgroup)
            {
                $sgroup = (new Sgroup())
                    ->setGroupName($row['group_name']);

                $this->em->persist($sgroup);
            }

            $address= $this -> em-> getRepository(Address::class)
                ->findOneBy([
                    'street_address' => $row['street_address'],
                    'postal_code' => $row['postal_code'],
                    'locality' => $row['locality']
                ]);

            if (null ===$address)
            {
                $address=(new Address())
                    ->setStreetAddress($row['street_address'])
                    ->setPostalCode($row['postal_code'])
                    ->setLocality($row['locality']);

                $this->em->persist($address);
            }

            $student
                ->setGroup($sgroup)
                ->setAddress($address);
        }

        $this->em->flush();
        $io->success('Everything went well!');
    }

}