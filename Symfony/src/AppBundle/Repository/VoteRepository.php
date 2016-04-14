<?php

namespace AppBundle\Repository;

/**
 * VoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VoteRepository extends \Doctrine\ORM\EntityRepository {

	public function findOneByParticulierPerturbationAndMessage($id_user, $id_pertu, $id_mess) {
		$vote = $this->createQueryBuilder('v')
			->where('v.particulier = :id_user')
			->setParameter('id_user', $id_user)
			->andWhere('v.perturbation = :id_pertu')
			->setParameter('id_pertu', $id_pertu)
			->andWhere('v.message = :id_mess')
			->setParameter('id_mess', $id_mess)
			->getQuery()
			->getOneOrNullResult();
		return $vote;
	}

}