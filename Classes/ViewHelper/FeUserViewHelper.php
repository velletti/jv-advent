<?php

namespace Jvelletti\JvAdvent\ViewHelper;

use Allplan\NemFeuser\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FeUserViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('uid', 'int', 'Frontend user UID', true);
    }

    /**
     * @return array{username: ?string, imagesrc: ?string, firstname: ?string, lastname: ?string}|array{}
     */
    public function render(): array
    {
        $uid = $this->arguments['uid'];

        if (class_exists(UserRepository::class)) {
            $repository = clone GeneralUtility::makeInstance(UserRepository::class);
            $querySettings = $repository->createQuery()->getQuerySettings();
            $querySettings->setRespectStoragePage(false);
            $querySettings->setIgnoreEnableFields(false);
            $querySettings->setIncludeDeleted(false);
            $repository->setDefaultQuerySettings($querySettings);
            /* @var \Allplan\NemFeuser\Domain\Model\User $user */
            $user = $repository->findUserByUids([$uid], 1)->getFirst();

            if ($user === null) {
                return [];
            }
            if( $user->getUsergroup() && count($user->getUsergroup()) > 0 ) {
                $userGroups = '';
                foreach( $user->getUsergroup() as $key => $userGroup) {
                    $userGroups .= $userGroup->getUid() . ",";
                }
            } else {
                $userGroups = $user->getNemUsergroup() ?? '' ;
            }

            return [
                'username' => $user->getUsername() === $user->getEmail() ? null : $user->getUsername(),
                'link'      => "/user/" . $user->getUsername() ,
                'imagesrc' => $user->getImagePath(),
                'firstname' => $user->getNemFirstname(),
                'lastname' => $user->getNemLastname(),
                'city' => $user->getCity() ,
                'icons' => $this->getGroupIcons($userGroups)
            ];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $user = $queryBuilder
            ->select('*')
            ->from('fe_users')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('disable', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT))
            )
            ->executeQuery()
            ->fetchAssociative();

        if ($user === false) {
            return [];
        }

        $imageSrc = null;

        return [
            'username'  => $user['username'] === $user['email'] ? null : $user['username'],

            'imagesrc'  => $imageSrc,
            'firstname' => ($user['first_name'] ?? ''),
            'lastname'  =>  ($user['last_name'] ?? ''),
            'city'      =>  ($user['city'] ?? ''),
            'icons'     =>   null
        ];
    }
    private function getGroupIcons(?string $groups =''): ?array
    {
        if ($groups === '') {
            return null;
        }

        $wanted = [10 => "User", 3 => "SP",7 => "Nem", 11 => "Lic" , 13 => "pending" ,  32 => "student",33 => "teacher" ];
        $result = [] ;
        $userUserGroupArray = GeneralUtility::intExplode(',', $groups, true);
        foreach ( $userUserGroupArray as  $key => $value) {
            if (array_key_exists($value, $wanted)) {
                $result[] = "Group_" . $value . "_" .$wanted[$value] ;
            }
        }
        asort( $result) ;
        return $result;
    }
}
